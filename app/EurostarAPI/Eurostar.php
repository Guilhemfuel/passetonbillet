<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\EurostarAPI;

use App\Exceptions\LastarException;
use App\Ticket;
use Exception;
use App\Station;
use App\Train;
use GuzzleHttp\Client;
use App\Exceptions\EurostarException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Eurostar
{
    private $retrieveURL;
    private $client;

    public function __construct( Client $customClient = null )
    {
        $this->retrieveURL = config( 'eurostar.booking_url' );
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
                        'x-apikey'     => config('eurostar.api_key')
                    ],
                ] );
            }

            public function request( $method, $uri = '', array $options = [] )
            {
                try {
                    return $this->client->request( $method, $uri, $options );
                } catch ( Exception $e ) {
                    if ( $e instanceof ClientException ) {
                        throw new EurostarException( $e->getMessage() );
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
     * @throws LastarException
     */
    public function retrieveTicket( $lastName, $referenceNumber, $past = false )
    {
        $response = $this->client->request(
            'GET',
            $this->retrieveURL . $referenceNumber . '/' . $lastName . '?locale=uk-en',
            [ 'http_errors' => false ]
        );

        if ( ! isset( json_decode( (string) $response->getBody(), true )[ 'booking' ] ) ) {
            throw new LastarException( 'Nothing found with this name/code combination.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new LastarException( 'Please try again later.' );
        }

        $decoded = json_decode( (string) $response->getBody(), true )[ 'booking' ];

        // Find tickets
        $buyerEmail = $decoded['contact']['email'];
        $currency = $decoded['currency'];
        $returnTickets = $decoded['isReturn'];
        $passengers = $decoded['passengers'];

        $tickets = [];

        foreach ($passengers as $passenger) {

            $outboundInfo = $passenger['outbound']['legs'][0];

            $ticket = $this->createTrainAndReturnTicket($outboundInfo,$currency, $lastName, $referenceNumber, $buyerEmail, true, $past);

            if ($ticket){
                array_push( $tickets, $ticket );
            }

            if ( $returnTickets ) {
                $inboundInfo = $passenger['inbound']['legs'][0];
                $ticketReturn = $this->createTrainAndReturnTicket($inboundInfo,$currency, $lastName, $referenceNumber, $buyerEmail, false, $past);
                if ($ticketReturn){
                    array_push( $tickets, $ticketReturn );
                }
            }
        }

        return $tickets;
    }

    private function createTrainAndReturnTicket($data, $currency, $lastName, $referenceNumber, $buyerEmail, $outbound = true, $past = false){

        $trainNumber = $data['info']['trainNumber'];
        $trainDepartureDate = $data['info']['departureDate'];
        $trainDepartureTime = $data['info']['departureTime'];
        $trainArrivalDate = $data['info']['arrivalDate'];
        $trainArrivalTime = $data['info']['arrivalTime'];
        $trainDepartureStation = Station::where( 'eurostar_id', $data['info']['origin']['code'] )->first();
        $trainArrivalStation = Station::where( 'eurostar_id', $data['info']['destination']['code'] )->first();

        if ( ! $trainDepartureStation ) {
            throw new LastarException( 'Station with code ' . $trainDepartureStation . ' not found.' );
        }
        if ( ! $trainArrivalStation ) {
            throw new LastarException( 'Station with code ' . $trainArrivalStation . ' not found.' );
        }

        if ( $past || $trainDepartureDate < new \DateTime() ) {
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

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = $boughtPrice;
            $ticket->bought_currency = $currency;
            $ticket->inbound = ! $outbound;
            $ticket->buyer_name = $lastName;
            $ticket->eurostar_code = $referenceNumber;
            $ticket->buyer_email = $buyerEmail;

           return $ticket;
        }

        return null;
    }

}