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
    private $baseURL;
    private $retrieveURL;
    private $client;

    const DATE_FORMAT_JSON = 'd/m/Y';
    const DATE_FORMAT_DB = 'Y-m-d';

    public function __construct(Client $customClient = null)
    {
        $this->baseURL = config( 'eurostar.trains_url' );
        $this->retrieveURL = config( 'eurostar.booking_url' );
        // wrap Guzzle Client in order to throw a EurostarException instead of a ClientException on a request
        $this->client = new class($customClient)
        {
            public $client;

            public function __construct($customClient = null)
            {
                if ($customClient){
                    $this->client = $customClient;
                    return;
                }

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
     * @param $departure_city Station
     * @param $arrival_city Station
     * @param $departure_date \Datetime
     *
     * @throws LastarException
     *
     * @return array
     */

    public function singles( Station $departure_station, Station $arrival_station, \DateTime $departure_date )
    {

        //Construct URL
        $url = $this->baseURL . "/single/outbound/" . $departure_station->eurostar_id . "/"
               . $arrival_station->eurostar_id . "/1/0/0/0/" . $departure_date->format(static::DATE_FORMAT_DB);

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

        if(count($decoded['proposal_sets'])==0){
            return $trains;
        }

        foreach ( $decoded['proposal_sets'] as $query_train ) {

            //Retrieve useful information
            $number = $query_train['proposals'][0]['tno'];
            $departure_time = $query_train['dep'];
            $arrival_time = $query_train['arr'];

            //Create new train
            $train = $train = new Train();
            $train->number = $number;
            $train->departure_date = $departure_date->format(static::DATE_FORMAT_DB);
            $train->arrival_date = $departure_date->format(static::DATE_FORMAT_DB);
            $train->departure_time = $departure_time;
            $train->arrival_time = $arrival_time;
            $train->departure_city = $departure_station->id;
            $train->arrival_city = $arrival_station->id;

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
    public function retrieveTicket( $lastName, $referenceNumber, $past = false )
    {
        $response = $this->client->request(
            'POST',
            $this->retrieveURL,
            [
                'http_errors' => false,
                'body'        => '{"travellers": [{"ln": "' . $lastName . '","pnr": "' . $referenceNumber . '"}]}'
            ]
        );

        if(!isset(json_decode( (string) $response->getBody(), true )[ $referenceNumber . '-' . $lastName ])) {
            throw new LastarException( 'Nothing found with this name/code combination.' );
        }

        $decoded = json_decode( (string) $response->getBody(), true )[ $referenceNumber . '-' . $lastName ]['LoadTravelOutput'];

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            if ( isset( $decoded['errors'][0]['code'] ) && $decoded['errors'][0]['code'] == 'API_1008' ) {
                return [];
            }
            throw new LastarException( 'Please try again later.' );
        }

        // Find tickets
        $buyerEmail = $decoded['contact']['email'];
        $currency = $decoded['currency'];
        $ticketsList = $decoded['JourneyRetrievePnrOutputs'];

        $tickets = [];

        foreach ( $ticketsList as $ticketInfo ) {

            // Retrieve train information
            $trainNumber = $ticketInfo['TravelSegments'][0]['marketingTrainNumber'];
            $trainDepartureDate = \DateTime::createFromFormat(static::DATE_FORMAT_JSON, $ticketInfo['departureDate']['date']);
            $trainDepartureTime = $ticketInfo['departureDate']['time'];
            $trainArrivalDate = \DateTime::createFromFormat(static::DATE_FORMAT_JSON, $ticketInfo['arrivalDate']['date']);
            $trainArrivalTime = $ticketInfo['arrivalDate']['time'];
            $trainDepartureStation = Station::where('eurostar_id', $ticketInfo['originCode'])->first();
            $trainArrivalStation = Station::where('eurostar_id', $ticketInfo['destinationCode'])->first();

            if(!$past && $trainDepartureDate < new \DateTime()){
                // We don't consider past tickets
                continue;
            }

            if(!$trainDepartureStation) {
                throw new LastarException( 'Station with code '.$trainDepartureStation.' not found.' );
            }
            if(!$trainArrivalStation) {
                throw new LastarException( 'Station with code '.$trainArrivalStation.' not found.' );
            }

            // Create train
//            dd(date("H:i:s", strtotime( $trainDepartureTime)));

            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => $trainDepartureDate,
                    'departure_time' => date("H:i:s", strtotime( $trainDepartureTime)),
                    'departure_city' => $trainDepartureStation->id,
                    'arrival_date'   => $trainArrivalDate,
                    'arrival_time'   => date("H:i:s", strtotime($trainArrivalTime)),
                    'arrival_city'   => $trainArrivalStation->id
                ]
            );

            // Retrieve ticket information
            $flexibility = $ticketInfo['FareAllocations'][0]['fareInformation']['flexibilityLevel'];
            $class = $ticketInfo['FareAllocations'][0]['fareInformation']['classOfService'];
            $boughtPrice = $ticketInfo['FareAllocations'][0]['fareInformation']['totalAmount'];
            $outbound = $ticketInfo['outboundIndicator'];

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = $boughtPrice;
            $ticket->bought_currency = $currency;
            $ticket->inbound = !$outbound;
            $ticket->buyer_name = $lastName;
            $ticket->eurostar_code = $referenceNumber;
            $ticket->buyer_email = $buyerEmail;

            array_push($tickets,$ticket);
        }

        return $tickets;
    }

}