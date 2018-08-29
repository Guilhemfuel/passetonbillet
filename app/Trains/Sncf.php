<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\Trains;

use App\Exceptions\SncfException;
use App\Ticket;
use Carbon\Carbon;
use Exception;
use App\Station;
use App\Train;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Sncf
{
    private $retrieveURL;
    private $client;

    const PROVIDER = "sncf";

    const DATE_FORMAT_JSON = 'd/m/Y';
    const TIME_FORMAT_DB = 'H:i:s';
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
        $referenceNumber = strtoupper($referenceNumber);

        $url = str_replace('{name}',$lastName,$this->retrieveURL);
        $url = str_replace('{booking_code}',$referenceNumber,$url);

        // Try for each version of SNCF website
        foreach ( ['fr_FR','en_UK'] as $country){

            $response = $this->client->request(
                'GET',
                str_replace('{country}',$country,$url),
                [ 'http_errors' => false ]
            );

            $decoded = json_decode( (string) $response->getBody(), true );

            if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS"  ) {
                continue;
            } else {
                break;
            }
        }

        if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS"  ) {
            throw new SncfException( 'Nothing found with this name/code combination.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new SncfException( 'Please try again later.' );
        }

        $decoded = $decoded["order"];
        $trainData = $decoded["trainFolders"][$referenceNumber];

        // Find tickets
        $transactionId = $trainData["transactionIds"][0];
        $price = $decoded ["transactions"][$transactionId]["amount"];
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

        if (count($data["segments"]) > 2 ) {
            $correspondance = true;
        }

        $trainNumber = $data["segments"][0]['trainNumber'];

        $departureDateTime = new Carbon($data["arrivalDate"]);
        $arrivalDateTime = new Carbon($data["departureDate"]);

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
        if ( $past || $departureDateTime->copy()->modify('-2 hour') >= new \DateTime() ) {
            // We don't consider past tickets

            // Create train
            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => $departureDateTime->format(self::DATE_FORMAT_DB),
                    'departure_time' => $departureDateTime->format(self::TIME_FORMAT_DB),
                    'departure_city' => $trainDepartureStation->id,
                    'arrival_date'   => $arrivalDateTime->format(self::DATE_FORMAT_DB),
                    'arrival_time'   => $arrivalDateTime->format(self::TIME_FORMAT_DB),
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

}