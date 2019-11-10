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

class Thalys extends TrainConnector
{
    private $bookingURL;
    protected $client;

    const PROVIDER = "thalys";

    const DATE_FORMAT_JSON = 'd/m/Y';
    const TIME_FORMAT_DB = 'H:i:s';
    const DATE_FORMAT_DB = 'Y-m-d';

    public function __construct( Client $customClient = null )
    {
        $this->bookingURL = config( 'trains.thalys.booking_url' );


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
                        'Host'       => 'www.thalys.com',
                        'Connection' => 'keep-alive',
                        'Origin'     => 'https://www.thalys.com',
                    ]
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

        $url = str_replace( '{name}', $lastName, $this->bookingURL );
        $url = str_replace( '{pnr}', $referenceNumber, $url );

        $response = $this->client->request( 'GET', $url );
        $bookings = json_decode( (string) $response->getBody(), true );

        $tickets = [];

        if ( ! $bookings ) {
            return null;
        }

        foreach ( $bookings as $booking ) {
            try {
                $ticket = $this->createTrainAndReturnTicket( $booking, $lastName, $referenceNumber, $past );
                $tickets[] = $ticket;
            } catch ( \Exception $error ) {
                \Log::info( "Thalys retrieval failed with booking code ${referenceNumber} and last name ${lastName}. Error: " . $error->getMessage() );
                continue;
            }
        }

        return $tickets;
    }

    /**
     * Given the information, create train and tickets
     */
    public function createTrainAndReturnTicket( $data, $lastName, $referenceNumber, $past )
    {

        $trainNumber = $data['TrainNumber'];

        $trainDepartureDate = $data['TravelDate'];
        $trainDepartureTime = $data['TravelTime'];
        $trainArrivalDate = $data['TravelDate'];
        $trainArrivalTime = $data['ArrivalTime'];

        $trainDepartureStation = null;
        $trainArrivalStation = null;

        $trainDepartureStation = Station::where( 'sncf_id', $data['OriginStation'] )->first();
        $trainArrivalStation = Station::where( 'sncf_id', $data['DestinationStation'] )->first();

        if ( $trainDepartureStation == null ) {
            throw new PasseTonBilletException( 'Departure station with code ' . $data['OriginStation'] . ' not found.' );
        }
        if ( $trainArrivalStation == null ) {
            throw new PasseTonBilletException( 'Arrival station with code ' . $data['DestinationStation'] . ' not found.' );
        }

        // You can sell ticket max two hours before train!
        if ( $past || ( ( new \DateTime( substr( $trainDepartureDate, 0, 10 ) . ' ' . $trainDepartureTime ) )
                            ->modify( '-2 hour' ) >= new \DateTime() ) ) {

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
            $flexibility = $data['TicketInfos']['FareName'];
            $class = $data['ComfortClass'];

            // Find price or fail
            $boughtPrice = null;
            if ( isset( $data['TicketInfos']['Amount'] ) ) {
                $boughtPrice = $data['TicketInfos']['Amount'];
            } elseif ( isset( $data['TicketInfos']['Transactions'] ) ) {
                foreach ( $data['TicketInfos']['Transactions'] as $transaction ) {
                    if ( $transaction['TransactionType'] == 'Sold' ) {
                        $boughtPrice = $transaction['Amount'];
                        break;
                    }
                }

            }

            if ( ! $boughtPrice ) {
                return null;
            }


            $ticketNumber = $data['TCN'];

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = intval( $boughtPrice );
            $ticket->bought_currency = 'EUR';
            $ticket->inbound = isset( $data['Direction'] ) ? $data['Direction'] == 'I' : false;
            $ticket->buyer_name = $lastName;
            $ticket->provider = self::PROVIDER;
            $ticket->provider_code = $referenceNumber;
            $ticket->ticket_number = $ticketNumber;
            $ticket->buyer_email = $data['BookingInfos'][0]['Email'];

            return $ticket;
        }

        return null;
    }


    /**
     * Download the ticket PDF from Thalys, and store it on S3
     * Also update ticket with the passbook_link
     */
    public function downloadAndReuploadPDF( Ticket $ticket )
    {
        return false;
    }

}