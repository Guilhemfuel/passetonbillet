<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\TrainsAPI;

use App\Exceptions\SncfException;
use App\Ticket;
use Exception;
use App\Station;
use App\Train;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class Sncf
{
    private $retrieveURL;
    private $client;

    const DATE_FORMAT_JSON = 'd/m/Y';
    const TIME_FORMAT_JSON = 'H:i';
    const DATE_FORMAT_DB = 'Y-m-d';

    public function __construct( Client $customClient = null )
    {
        $this->retrieveURL = config( 'trains.sncf.booking_url' );
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
                        'Content-type' => 'application/json',
                        'Accept'       => 'application/json',
                        'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
                        'Cache-Control' => 'no-cache',
                        'Connection' => 'keep-alive',
                        'Host' => 'en.oui.sncf'
                    ],
                ] );
            }

            public function request( $method, $uri = '', array $options = [] )
            {
                try {
                    return $this->client->request( $method, $uri, $options );
                } catch ( Exception $e ) {
                    if ( $e instanceof ClientException ) {
                        throw new SncfException( $e->getMessage() );
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
     * @throws PasseTonBilletException
     */
    public function retrieveTicket( $lastName, $referenceNumber, $past = false )
    {


        $response = $this->client->request(
            'GET',
            $this->retrieveURL . $referenceNumber . '/' . $lastName . '?locale=uk-en',
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

        // Find tickets
        $buyerEmail = $decoded['contact']['email'];
        $currency = $decoded['currency'];
        $returnTickets = $decoded['isReturn'];
        $passengers = $decoded['passengers'];

        $tickets = [];

        foreach ( $passengers as $passenger ) {

            $outboundInfo = $passenger['outbound']['legs'][0];

            $ticket = $this->createTrainAndReturnTicket( $outboundInfo, $currency, $lastName, $referenceNumber, $buyerEmail, true, $past );

            if ( $ticket ) {
                array_push( $tickets, $ticket );
            }

            if ( $returnTickets ) {
                $inboundInfo = $passenger['inbound']['legs'][0];
                $ticketReturn = $this->createTrainAndReturnTicket( $inboundInfo, $currency, $lastName, $referenceNumber, $buyerEmail, false, $past );
                if ( $ticketReturn ) {
                    array_push( $tickets, $ticketReturn );
                }
            }
        }

        return $tickets;
    }

    public function createTrainAndReturnTicket( $data, $currency, $lastName, $referenceNumber, $buyerEmail, $outbound = true, $past = false )
    {


        $trainNumber = $data['info']['trainNumber'];
        $trainDepartureDate = $data['info']['departureDate'];
        $trainDepartureTime = $data['info']['departureTime'];
        $trainArrivalDate = $data['info']['arrivalDate'];
        $trainArrivalTime = $data['info']['arrivalTime'];

        $trainDepartureStation = null;
        $trainArrivalStation = null;

        $trainDepartureStation = Station::where( 'eurostar_id', $data['info']['origin']['code'] )->first();
        $trainArrivalStation = Station::where( 'eurostar_id', $data['info']['destination']['code'] )->first();

        if ( $trainDepartureStation == null ) {
            throw new SncfException( 'Departure station with code ' . $data['info']['origin']['code'] . ' not found.' );
        }
        if ( $trainArrivalStation == null ) {
            throw new SncfException( 'Arrival station with code ' . $data['info']['destination']['code'] . ' not found.' );
        }

        // You can sell ticket max two hours before train!
        if ( $past || (  (new \DateTime(  $trainDepartureDate.' '. $trainDepartureTime  ))->modify('-2 hour') >= new \DateTime() ) ) {
            // We don't consider past tickets

            // Create train
            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => $trainDepartureDate,
                    'departure_time' => date( "H:i:s", strtotime( $trainDepartureTime ) ),
                    'departure_city' => $trainDepartureStation->id,
                    'arrival_date'   => $trainArrivalDate,
                    'arrival_time'   => date( "H:i:s", strtotime( $trainArrivalTime ) ),
                    'arrival_city'   => $trainArrivalStation->id
                ]
            );

            // Retrieve ticket information
            $flexibility = $data['fare']['flexibilityLevel'];
            $class = $data['fare']['classOfService'];
            $boughtPrice = $data['fare']['totalFarePrice'];
            $ticketNumber = $data['fare']['tcn'];

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = intval( $boughtPrice );
            $ticket->bought_currency = $currency;
            $ticket->inbound = ! $outbound;
            $ticket->buyer_name = $lastName;
            $ticket->eurostar_code = $referenceNumber;
            $ticket->eurostar_ticket_number = $ticketNumber;
            $ticket->buyer_email = $buyerEmail;

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

        if(!isset($decoded['etapBooking']['ticketsData'])){
            \Log::debug($decoded);
        }

        foreach ( $decoded['etapBooking']['ticketsData']['tickets'] as $ticketData ) {
            // Fill the number of ticket seen for each passenger
            isset($passengersIndex[$ticketData['passengerId']])?$passengersIndex[$ticketData['passengerId']]++:$passengersIndex[$ticketData['passengerId']]=0;

            if ( $ticketData['ticketNumber'] == $ticket->eurostar_ticket_number ) {
                $passengerId = $ticketData['passengerId'];
                // Order of ticket for this passenger
                $ticketIndex = $passengersIndex[$ticketData['passengerId']];
            }
        }


        // Now retrieve and save passbook url
        $ticket->passbook_link = $decoded['etapBooking']['ticketsData']['passbook'][$ticket->eurostar_ticket_number];
        $ticket->save();

        // Now that we retrieved passenger id, we simply need to do a post to retrieve and download the ticket
        $response = $this->client->request(
            'POST',
            $this->pdfURL . $ticket->eurostar_code . '/passengers/' . $passengerId . '/tickets?pos=GBZXA',
            [
                'body' => \GuzzleHttp\json_encode([
                    "type"     => "PAH",
                    "language" => "en",
                    "combine"  => false
                ]),
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
        } catch (\Exception $exception) {
            if (count($decoded)==1){
                $pdfUrl = $decoded[ 0 ]['url'];
            } else {
                \Log::error('Error while finding pdf.... '.print_r($decoded));
                return false;
            }
        }

        \Log::debug($ticketIndex);


        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile(StreamReader::createByString(file_get_contents($pdfUrl)));
        // Only import the page needed.
        \Log::debug('pagecount: '.$pageCount);
        \Log::debug('$ticketIndex: '.($ticketIndex));

        if($pageCount < (1+$ticketIndex) ){
            $ticketIndex = $pageCount%($ticketIndex);
        }
        $page = $pdf->importPage(1+$ticketIndex);
        $pdf->AddPage();
        $pdf->useTemplate($page);

        \Storage::disk('s3')->put('pdf/tickets/'.$ticket->pdf_file_name, (string) $pdf->Output("S"));

        return true;
    }

}