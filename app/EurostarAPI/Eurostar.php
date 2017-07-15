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
use Symfony\Component\Debug\Debug;

class Eurostar
{
    private $baseURL;
    private $retrieveURL;
    private $client;

    public function __construct()
    {
        $this->baseURL = config( 'eurostar.trains_url' );
        $this->retrieveURL = config( 'eurostar.booking_url' );
        // wrap Guzzle Client in order to throw a EurostarException instead of a ClientException on a request
        $this->client = new class
        {
            public $client;

            public function __construct()
            {
                $this->client = new Client( [
                    'headers' => [
                        'Content-type' => 'application/json',
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
     * Take a a depart city, an arrival city and a date
     * Return an array of trains for that day
     *
     * @param $departure_city
     * @param $arrival_city
     * @param $departure_date
     *
     * @return array
     */

    public function singles( Station $departure_station, Station $arrival_station, $departure_date )
    {

        //Construct URL
        $url = $this->baseURL . "/single/outbound/" . $departure_station->eurostar_id . "/"
               . $arrival_station->eurostar_id . "/1/0/0/0/" . $departure_date;

        $response = $this->client->request(
            'GET',
            $url,
            [ 'http_errors' => false ]
        );

        $decoded = json_decode( (string) $response->getBody(), true );

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            if ( isset( $decoded['errors'][0]['code'] ) && $decoded['errors'][0]['code'] == 'API_1008' ) {
                return [];
            }
            throw new LastarException( 'Please try again later.' );
        }

        $trains = [];

        foreach ( $decoded['proposal_sets'] as $query_train ) {

            //Retrieve useful information
            $number = $query_train['proposals'][0]['tno'];
            $departure_time = $query_train['dep'];
            $arrival_time = $query_train['arr'];


            //Create new train
            $train = $train = new Train();
            $train->number = $number;
            $train->departure_date = $departure_date;
            $train->departure_time = $departure_time;
            $train->arrival_time = $arrival_time;
            $train->departure_city = $departure_station->eurostar_id;
            $train->arrival_city = $arrival_station->eurostar_id;

            //Add it to array
            array_push( $trains, $train );
        }

        return $trains;
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
    public function retrieveTicket( $lastName, $referenceNumber )
    {
        $response = $this->client->request(
            'POST',
            $this->retrieveURL,
            [
                'http_errors' => false,
                'body'        => '{"travellers": [{"ln": "' . $lastName . '","pnr": "' . $referenceNumber . '"}]}'
            ]
        );

        $decoded = json_decode( (string) $response->getBody(), true )[ $referenceNumber . '-' . $lastName ]['LoadTravelOutput'];

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            if ( isset( $decoded['errors'][0]['code'] ) && $decoded['errors'][0]['code'] == 'API_1008' ) {
                return [];
            }
            throw new LastarException( 'Please try again later.' );
        }

        // Find tickets
        $currency = $decoded['currency'];
        $ticketsList = $decoded['JourneyRetrievePnrOutputs'];

        \Debugbar::info($ticketsList);


        $tickets = [];

        foreach ( $ticketsList as $ticketInfo ) {

            \Debugbar::info($ticketInfo);

            // Retrieve useful information
            $trainNumber = $ticketInfo['TravelSegments'][0]['marketingTrainNumber'];
            $trainDepartureDate = $ticketInfo['departureDate']['date'];
            $trainDepartureTime = $ticketInfo['departureDate']['time'];
            $trainArrivalDate = $ticketInfo['arrivalDate']['date'];
            $trainArrivalTime = $ticketInfo['arrivalDate']['time'];
            $trainDepartureStation = $ticketInfo['originCode'];
            $trainArrivalStation = $ticketInfo['destinationCode'];

            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => $trainDepartureDate,
                    'departure_time' => $trainDepartureTime,
                    'departure_city' => $trainDepartureStation,
                    'arrival_date'   => $trainArrivalDate,
                    'arrival_time'   => $trainArrivalTime,
                    'arrival_city'   => $trainArrivalStation
                ]
            );

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;

            // TODO: finish completing ticket info

        }

        return $ticketsList;
    }

}