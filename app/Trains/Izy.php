<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\Trains;

use App\Exceptions\PasseTonBilletException;
use App\Ticket;
use Carbon\Carbon;
use Exception;
use App\Station;
use App\Train;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class Izy extends TrainConnector
{
    private $authURL;
    private $bookingURL;
    private $clientID;
    private $grantType;

    const PROVIDER = 'izy';

    const DATE_FORMAT_JSON = 'd/m/Y';
    const TIME_FORMAT_JSON = 'H:i';
    const DATE_FORMAT_DB = 'Y-m-d';

    public function __construct( Client $customClient = null )
    {

        $this->authURL = config( 'trains.izy.auth_url' );
        $this->bookingURL = config( 'trains.izy.booking_url' );
        $this->clientID = config( 'trains.izy.client_id' );
        $this->grantType = config( 'trains.izy.grant_type' );


        // wrap Guzzle Client in order to throw a PasseTonBilletException instead of a ClientException on a request
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
                        'Content-type'    => 'application/json',
                        'Accept'          => 'application/json',
                        'Accept-Language' => 'en-GB',
                        'Origin'          => ' https://booking.izy.com'
                    ],
                ] );
            }

            public function request( $method, $uri = '', array $options = [] )
            {
                try {
                    return $this->client->request( $method, $uri, $options );
                } catch ( Exception $e ) {
                    if ( $e instanceof ClientException ) {
                        throw new PasseTonBilletException( $e->getMessage() );
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
    public function retrieveTicket( $email, $lastName, $referenceNumber, $past = false )
    {
        $referenceNumber = strtoupper( $referenceNumber );
        $email = strtolower( $email );

        // First we connect using their Oauth services
        $response = $this->client->request(
            'POST',
            $this->authURL,
            [
                'body'    => \GuzzleHttp\json_encode( [
                    "booking_number" => $referenceNumber,
                    "email"          => $email,
                    "grant_type"     => $this->grantType
                ] ),
                'headers' => [
                    'Authorization' => 'Basic ' . $this->clientID,
                    'User-Agent'    => null,
                ]
            ]
        );

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new PasseTonBilletException( 'Please try again later.' );
        }

        if ( ! isset( json_decode( (string) $response->getBody(), true )['access_token'] ) ) {
            throw new PasseTonBilletException( 'Nothing found with this name/code combination.' );
        }

        $bookingUrl = str_replace( '{pnr}', $referenceNumber, $this->bookingURL );
        $accessToken = json_decode( (string) $response->getBody(), true )['access_token'];
        $response = $this->client->request(
            'GET',
            $bookingUrl,
            [
                'http_errors' => false,
                'headers'     => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'User-Agent'    => null,
                ]
            ]
        );

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new PasseTonBilletException( 'Please try again later.' );
        }

        if ( ! isset( json_decode( (string) $response->getBody(), true )['booking_number'] ) ) {
            throw new PasseTonBilletException( 'Nothing found with this name/code combination.' );
        }

        $data = json_decode( (string) $response->getBody(), true );

        // Find tickets
        $buyerEmail = $data['customer']['email'];
        $currency = $data['currency'];
        $lastName = $data['customer']['last_name'];
        $returnTickets = isset( $data['outbound_booking_tariff_segments'] ) && isset( $data['inbound_booking_tariff_segments'] );

        $tickets = [];

        $ticketInfos = $data['outbound_booking_tariff_segments'];
        if ( $returnTickets ) {
            $ticketInfos = array_merge(  $data['inbound_booking_tariff_segments'], $ticketInfos );
        }

        foreach ( $ticketInfos as $ticketInfo ) {


            $ticket = $this->createTrainAndReturnTicket( $ticketInfo, $currency, $lastName, $referenceNumber, $buyerEmail, true, $past );

            if ( $ticket ) {
                array_push( $tickets, $ticket );
            } else {
                \Log::info("Izy retrieval failed with booking code ${referenceNumber} and last name ${lastName}.");
            }

        }

        return $tickets;
    }

    /**
     * Given the information, create train and tickets
     */
    public function createTrainAndReturnTicket( $data, $currency, $lastName, $referenceNumber, $buyerEmail, $outbound = true, $past = false )
    {


        $trainNumber = $data['validity_service'];


        $firstTravelSegment = $data['booking_journey_segments'][0];
        $lastTravelSegment = $data['booking_journey_segments'][ count( $data['booking_journey_segments'] ) - 1 ];

        $trainDepartureDateTime = $firstTravelSegment['departure_date_time'];
        $trainArrivalDateTime = $lastTravelSegment['arrival_date_time'];

        $trainDepartureStation = Station::where( 'uic', substr( $firstTravelSegment['departure_station']['_u_i_c_station_code'], 2 ) )->first();
        $trainArrivalStation = Station::where( 'uic', substr( $firstTravelSegment['arrival_station']['_u_i_c_station_code'], 2 ) )->first();

        if ( ! $trainDepartureStation ) {
            throw new PasseTonBilletException( 'Departure station with code ' . $data['info']['origin']['code'] . ' not found.' );
        }
        if ( ! $trainArrivalStation ) {
            throw new PasseTonBilletException( 'Arrival station with code ' . $data['info']['destination']['code'] . ' not found.' );
        }

        // You can sell ticket max two hours before train!
        if ( $past || ( ( new \DateTime( $trainDepartureDateTime ) )->modify( '-2 hour' ) >= new \DateTime() ) ) {
            // We don't consider past tickets

            // Create train
            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => ( new Carbon( $trainDepartureDateTime ) )->format( self::DATE_FORMAT_DB ),
                    'departure_time' => ( new Carbon( $trainDepartureDateTime ) )->format( 'H:i:s' ),
                    'departure_city' => $trainDepartureStation->id,
                    'arrival_date'   => ( new Carbon( $trainArrivalDateTime ) )->format( self::DATE_FORMAT_DB ),
                    'arrival_time'   => ( new Carbon( $trainArrivalDateTime ) )->format( 'H:i:s' ),
                    'arrival_city'   => $trainArrivalStation->id
                ]
            );

            // Retrieve ticket information
            $flexibility = $data['required_products'][0]['code'];
            $class = $data['required_products'][0]['name'];
            $boughtPrice = $data['required_products'][0]['price'];
            $ticketNumber = $data['required_products'][0]['ticket_number'];

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = intval( $boughtPrice );
            $ticket->bought_currency = $currency;
            $ticket->inbound = ! $outbound;
            $ticket->buyer_name = $lastName;
            $ticket->provider = self::PROVIDER;
            $ticket->provider_code = $referenceNumber;
            $ticket->ticket_number = $ticketNumber;
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

        /**
         * Only if there is only one passenger and no more than one travel segment
         */

        // We first want to get the authorization code for this, as it has to be freshly emitted by eurostar
        $response = $this->client->request(
            'GET',
            $this->retrieveURL . $ticket->provider_code . '/' . $ticket->buyer_name . '?locale=uk-en',
            [ 'http_errors' => false ]
        );

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() != 200 ) {
            throw new PasseTonBilletException( 'Please try again later.' );
        }

        if ( ! isset( json_decode( (string) $response->getBody(), true )['booking'] ) ) {
            throw new PasseTonBilletException( 'Nothing found with this name/code combination.' );
        }

        $decoded = json_decode( (string) $response->getBody(), true )['booking'];

        $accessToken = $decoded['etapBooking']['accessToken'];
        $ticketIndex = 0;
        $passengersIndex = [];
        $passengerId = null;

        if ( ! isset( $decoded['etapBooking']['ticketsData'] ) ) {
            // Data was not filled regading travellers on eurostar website, so he have to fill it
            $this->fillPassengerInformation( $ticket );
        }

        foreach ( $decoded['etapBooking']['ticketsData']['tickets'] as $ticketData ) {
            // Fill the number of ticket seen for each passenger
            isset( $passengersIndex[ $ticketData['passengerId'] ] ) ? $passengersIndex[ $ticketData['passengerId'] ] ++ : $passengersIndex[ $ticketData['passengerId'] ] = 0;

            if ( $ticketData['ticketNumber'] == $ticket->ticket_number ) {
                $passengerId = $ticketData['passengerId'];
                // Order of ticket for this passenger
                $ticketIndex = $passengersIndex[ $ticketData['passengerId'] ];
            }
        }

        // Now retrieve and save passbook url
        // TODO: reactivate passbook
        // $ticket->passbook_link = $decoded['etapBooking']['ticketsData']['passbook'][$ticket->ticket_number];
        // $ticket->save();

        // Now that we retrieved passenger id, we simply need to do a post to retrieve and download the ticket
        $response = $this->client->request(
            'POST',
            $this->pdfURL . $ticket->provider_code . '/passengers/' . $passengerId . '/tickets?pos=GBZXA',
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
                    'cid'           => 'myb-' . strtoupper( str_random( 5 ) ) . '-' . strtoupper( str_random( 5 ) ),
                    'User-Agent'    => null,
                ]
            ]
        );

        if ( ! isset( json_decode( (string) $response->getBody(), true )['tickets'] ) ) {
            throw new PasseTonBilletException( 'Nothing found for this passenger.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new PasseTonBilletException( 'Please try again later.' );
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

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile( StreamReader::createByString( file_get_contents( $pdfUrl ) ) );

        if ( $pageCount < ( 1 + $ticketIndex ) ) {
            $ticketIndex = $ticketIndex % $pageCount;
        }
        $page = $pdf->importPage( 1 + $ticketIndex );
        $pdf->AddPage();
        $pdf->useTemplate( $page );

        \Storage::disk( 's3' )->put( 'pdf/tickets/' . $ticket->pdf_file_name, (string) $pdf->Output( "S" ) );

        return true;
    }

}