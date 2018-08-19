<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\Trains;

use App\Exceptions\SncfException;
use App\Exceptions\ThalysException;
use App\Ticket;
use Carbon\Carbon;
use Exception;
use App\Station;
use App\Train;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class Thalys
{
    private $retrieveURL;
    private $client;

    const PROVIDER = "thalys";

    const DATE_FORMAT_JSON = 'd/m/Y';
    const TIME_FORMAT_DB = 'H:i:s';
    const DATE_FORMAT_DB = 'Y-m-d';

    public function __construct( Client $customClient = null )
    {
        $this->retrieveURL = config( 'trains.thalys.booking_url' );
        // wrap Guzzle Client in order to throw a EurostarException instead of a ClientException on a request
        $this->client = new class( $customClient )
        {
            public $client;

            public function __construct( $customClient = null )
            {
                if ( $customClient ) {
                    $this->client = $customClient;

                    return;
                }

                $this->client = new Client( [
                    'headers' => [
                        'Ca'           => 'no-cache',
                        'Accept'       => '*/*',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Host'         => 'www.thalys.com',
                        'Connection'   => 'keep-alive',
                        'Origin'       => 'https://www.thalys.com',
                        'Referer'      => 'https://www.thalys.com/be/en/'
                    ],
                ] );
            }

            public function request( $method, $uri = '', array $options = [] )
            {
                try {
                    return $this->client->request( $method, $uri, $options );
                } catch ( Exception $e ) {
                    if ( $e instanceof ClientException ) {
                        throw new ThalysException( $e->getMessage() );
                    }
                    throw $e;
                }
            }
        };
    }

    /**
     *
     * Take a name and a lastname and returns ticket information (create train if not in database)
     *
     * @param $lastName
     * @param $referenceNumber
     *
     * @return array
     * @throws ThalysException
     */
    public function retrieveTicket( $lastName, $referenceNumber, $past = false )
    {
        $referenceNumber = strtoupper( $referenceNumber );

        $cookiesJar = new CookieJar();
        $response = $this->client->request(
            'POST',
            $this->retrieveURL,
            [
                'http_errors' => false,
                'form_params' => [
                    'lg'                => 'en',
                    'country'           => 'be',
                    'popup_billets_pnr' => 'SXNAHL',
                    'popup_billets_nom' => 'nahum'
                ],
                'cookies'     => $cookiesJar
            ]
        );

        $decoded = json_decode( (string) $response->getBody(), true );

        if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS" ) {
            throw new ThalysException( 'Nothing found with this name/code combination.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new ThalysException( 'Please try again later.' );
        }

        $url = $decoded["url"];

        $phpSessId = null;
        foreach ( $cookiesJar->toArray() as $cookie ) {
            if ( $cookie["Name"] == 'PHPSESSID' ) {
                $phpSessId = $cookie['Value'];
                break;
            }
        }

        // If cookie was not found error
        if ( ! $phpSessId ) {
            throw new ThalysException( 'Please try again later.' );
        }

        $response = $this->client->request( 'GET',
            config( 'trains.thalys.base_url' ) . $url,
            [
                'http_errors' => false,
                'headers'     => [
                    'Cookie'          => "PHPSESSID={$phpSessId};",
                    'Accept-Encoding' => "gzip, deflate, br",
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36',
                    'Referer'         => 'https://www.thalys.com/fr/en/services/before/your-train-ticket'
                ]
            ] );

        dd(config( 'trains.thalys.base_url' ) . $url,$response->getBody(true)->getContents());

        $doc = new \DOMDocument();
        $doc->loadHTML($response->getBody(true)->getContents());


        echo $response->getBody(true)->getContents();
        dd();

        $decoded = json_decode( (string) $response->getBody(), true );

        dd($decoded);


        // Find tickets
        $transactionId = $trainData["transactionIds"][0];
        $price = $decoded ["transactions"][ $transactionId ]["amount"];
        $buyerEmail = $decoded['initialContact']['emailAddress'];
        $currency = "EUR";

        $tickets = [];

        // For each travel
        foreach ( $trainData['travels'] as $travel ) {

            $ticket = $this->createTrainAndReturnTicket( $travel, $currency, $lastName, $referenceNumber, $buyerEmail, $price, $past );

            if ( $ticket ) {
                array_push( $tickets, $ticket );
            }

        }

        return $tickets;
    }

    public function createTrainAndReturnTicket( $data, $currency, $lastName, $referenceNumber, $buyerEmail, $price, $past = false )
    {

        // Check if correspondance
        $correspondance = false;

        if ( count( $data["segments"] ) > 2 ) {
            $correspondance = true;
        }

        $trainNumber = $data["segments"][0]['trainNumber'];

        $departureDateTime = new Carbon( $data["arrivalDate"] );
        $arrivalDateTime = new Carbon( $data["departureDate"] );

        $trainDepartureStation = null;
        $trainArrivalStation = null;

        $trainDepartureStation = Station::where( 'sncf_id', $data['origin']['stationResarailCode'] )->first();
        $trainArrivalStation = Station::where( 'sncf_id', $data['destination']['stationResarailCode'] )->first();

        if ( $trainDepartureStation == null ) {
            throw new SncfException( 'Departure station with code ' . $data['origin']['stationResarailCode'] . ' not found.' );
        }
        if ( $trainArrivalStation == null ) {
            throw new SncfException( 'Arrival station with code ' . $data['destination']['stationResarailCode'] . ' not found.' );
        }

        // You can sell ticket max two hours before train!
        if ( $past || $departureDateTime->modify( '-2 hour' ) >= new \DateTime() ) {
            // We don't consider past tickets

            // Create train
            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => $departureDateTime->format( self::DATE_FORMAT_DB ),
                    'departure_time' => $departureDateTime->format( self::TIME_FORMAT_DB ),
                    'departure_city' => $trainDepartureStation->id,
                    'arrival_date'   => $arrivalDateTime->format( self::DATE_FORMAT_DB ),
                    'arrival_time'   => $arrivalDateTime->format( self::TIME_FORMAT_DB ),
                    'arrival_city'   => $trainArrivalStation->id
                ]
            );

            // Retrieve ticket information
            $flexibility = $data['fareFlexibility'];
            $class = $data['segments'][0]['comfortClass'];
            $boughtPrice = $price;

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = intval( $boughtPrice );
            $ticket->bought_currency = $currency;
            $ticket->inbound = $data["type"] != "OUTWARD";
            $ticket->buyer_name = $lastName;
            $ticket->provider_code = $referenceNumber;
            $ticket->provider = self::PROVIDER;
            $ticket->buyer_email = $buyerEmail;
            $ticket->correspondence = $correspondance;


            return $ticket;
        }

        return null;
    }

    /**
     * Download the ticket PDF from eurostar, and store it on S3
     * Also update ticket with the passbook_link
     */
    public function downloadAndReuploadPDF( Ticket $ticket )
    {

        // We first want to get the authorization code for this, as it has to be freshly emitted by eurostar
        $response = $this->client->request(
            'GET',
            $this->retrieveURL . $ticket->eurostar_code . '/' . $ticket->buyer_name . '?locale=uk-en',
            [ 'http_errors' => false ]
        );

        if ( ! isset( json_decode( (string) $response->getBody(), true )['booking'] ) ) {
            throw new SncfException( 'Nothing found with this name/code combination.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new SncfException( 'Please try again later.' );
        }

        $decoded = json_decode( (string) $response->getBody(), true )['booking'];

        $accessToken = $decoded['etapBooking']['accessToken'];
        $ticketIndex = 0;
        $passengersIndex = [];

        if ( ! isset( $decoded['etapBooking']['ticketsData'] ) ) {
            \Log::debug( $decoded );
        }

        foreach ( $decoded['etapBooking']['ticketsData']['tickets'] as $ticketData ) {
            // Fill the number of ticket seen for each passenger
            isset( $passengersIndex[ $ticketData['passengerId'] ] ) ? $passengersIndex[ $ticketData['passengerId'] ] ++ : $passengersIndex[ $ticketData['passengerId'] ] = 0;

            if ( $ticketData['ticketNumber'] == $ticket->eurostar_ticket_number ) {
                $passengerId = $ticketData['passengerId'];
                // Order of ticket for this passenger
                $ticketIndex = $passengersIndex[ $ticketData['passengerId'] ];
            }
        }


        // Now retrieve and save passbook url
        $ticket->passbook_link = $decoded['etapBooking']['ticketsData']['passbook'][ $ticket->eurostar_ticket_number ];
        $ticket->save();

        // Now that we retrieved passenger id, we simply need to do a post to retrieve and download the ticket
        $response = $this->client->request(
            'POST',
            $this->pdfURL . $ticket->eurostar_code . '/passengers/' . $passengerId . '/tickets?pos=GBZXA',
            [
                'body'    => \GuzzleHttp\json_encode( [
                    "type"     => "PAH",
                    "language" => "en",
                    "combine"  => false
                ] ),
                'headers' => [
                    'Accept'        => 'application/json, text/plain, */*',
                    'x-apikey'      => config( 'trains.eurostar.api_key_web' ),
                    'Authorization' => $accessToken,
                    'cid'           => str_random( 20 ),
                    'User-Agent'    => null,
                ]
            ]
        );

        if ( ! isset( json_decode( (string) $response->getBody(), true )['tickets'] ) ) {
            throw new SncfException( 'Nothing found for this passenger.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new SncfException( 'Please try again later.' );
        }

        $decoded = json_decode( (string) $response->getBody(), true )['tickets'];
        try {
            $pdfUrl = $decoded[ $ticketIndex ]['url'];
        } catch ( \Exception $exception ) {
            if ( count( $decoded ) == 1 ) {
                $pdfUrl = $decoded[0]['url'];
            } else {
                \Log::error( 'Error while finding pdf.... ' . print_r( $decoded ) );

                return false;
            }
        }

        \Log::debug( $ticketIndex );


        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile( StreamReader::createByString( file_get_contents( $pdfUrl ) ) );
        // Only import the page needed.
        \Log::debug( 'pagecount: ' . $pageCount );
        \Log::debug( '$ticketIndex: ' . ( $ticketIndex ) );

        if ( $pageCount < ( 1 + $ticketIndex ) ) {
            $ticketIndex = $pageCount % ( $ticketIndex );
        }
        $page = $pdf->importPage( 1 + $ticketIndex );
        $pdf->AddPage();
        $pdf->useTemplate( $page );

        \Storage::disk( 's3' )->put( 'pdf/tickets/' . $ticket->pdf_file_name, (string) $pdf->Output( "S" ) );

        return true;
    }

}