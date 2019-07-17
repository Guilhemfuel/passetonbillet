<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\Trains;

use App\Exceptions\PasseTonBilletException;
use App\Facades\AppHelper;
use App\Ticket;
use Carbon\Carbon;
use Exception;
use App\Station;
use App\Train;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Sncf extends TrainConnector
{
    private $retrieveURL;
    protected $client;

    private $passengers;

    const PROVIDER = "sncf";

    const DATE_FORMAT_JSON = 'd/m/Y';
    const TIME_FORMAT_DB = 'H:i:s';
    const DATE_FORMAT_DB = 'Y-m-d';

    public function __construct( Client $customClient = null )
    {
        $this->retrieveURL = config( 'trains.sncf.booking_url' );
        $this->pdfURL = config( 'trains.sncf.pdf_url' );
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
                        'Content-type'    => 'application/json',
                        'Accept'          => 'application/json',
                        'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
                        'Cache-Control'   => 'no-cache',
                        'Connection'      => 'keep-alive',
                        'Host'            => 'en.oui.sncf'
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

        $url = str_replace( '{name}', $lastName, $this->retrieveURL );
        $url = str_replace( '{booking_code}', $referenceNumber, $url );

        // Try for each version of SNCF website
        foreach ( [ 'fr_FR', 'en_UK' ] as $country ) {

            $response = $this->client->request(
                'GET',
                str_replace( '{country}', $country, $url ),
                [ 'http_errors' => false ]
            );

            $decoded = json_decode( (string) $response->getBody(), true );

            if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS" ) {
                continue;
            } else {
                break;
            }
        }

        if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS" ) {
            throw new PasseTonBilletException( 'Nothing found with this name/code combination.' );
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() == 500 ) {
            throw new PasseTonBilletException( 'Please try again later.' );
        }

        $decoded = $decoded["order"];
        $databaseId = $decoded["databaseId"];
        $trainData = $decoded["trainFolders"][ $referenceNumber ];

        // Find tickets
        $transactionId = $trainData["transactionIds"][0];
        $price = $decoded ["transactions"][ $transactionId ]["amount"];
        $buyerEmail = $decoded['initialContact']['emailAddress'];
        $currency = "EUR";

        $this->passengers = $trainData['passengers'];

        $tickets = [];

        // For each travel
        foreach ( $trainData['travels'] as $travel ) {

            foreach ( $travel['passengerIds'] as $passenger ) {
                $ticket = $this->createTrainAndReturnTicket( $travel, $currency, $lastName, $referenceNumber, $buyerEmail, $price, $databaseId,$passenger, $past );

                if ( $ticket ) {
                    array_push( $tickets, $ticket );
                }
            }

        }

        return $tickets;
    }

    public function createTrainAndReturnTicket( $data, $currency, $lastName, $referenceNumber, $buyerEmail, $price, $databaseId, $passenger, $past = false )
    {

        // Check if correspondance
        $correspondance = false;

        if ( count( $data["segments"] ) > 2 ) {
            $correspondance = true;
        }

        // Find passenger
        $passengerFound = false;
        foreach ($this->passengers as $pass) {
            if ($pass['passengerId'] == $passenger) {
                $passenger = $pass;
                $passengerFound = true;
                break;
            }
        }
        if (!$passengerFound) {
            throw new \Exception('Passenger with id '.$passenger.' for resa '.$lastName.'/'.$referenceNumber.' not found!');
        }

        $trainNumber = $data["segments"][0]['trainNumber'];
        $id = $databaseId . '0' . str_replace(".", "", $passenger['passengerId']) .
            substr($passenger['firstName'],0,3) . substr($passenger['lastName'],0,3);

        $departureDateTime = new Carbon( $data["departureDate"] );
        $arrivalDateTime = new Carbon( $data["arrivalDate"] );

        $trainDepartureStation = null;
        $trainArrivalStation = null;

        $trainDepartureStation = Station::where( 'sncf_id', $data['origin']['stationResarailCode'] )->first();
        $trainArrivalStation = Station::where( 'sncf_id', $data['destination']['stationResarailCode'] )->first();

        if ( $trainDepartureStation == null ) {
            throw new PasseTonBilletException( 'Departure station with code ' . $data['origin']['stationResarailCode'] . ' not found.' );
        }
        if ( $trainArrivalStation == null ) {
            throw new PasseTonBilletException( 'Arrival station with code ' . $data['destination']['stationResarailCode'] . ' not found.' );
        }

        // You can sell ticket max two hours before train!
        if ( $past || $departureDateTime->copy()->modify( '-2 hour' ) >= new \DateTime() ) {
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

            if (!isset($data['amountByPassenger']) || !isset($data['amountByPassenger'][$passenger['passengerId']])) {
                return null;
            }
            $boughtPrice = $data['amountByPassenger'][$passenger['passengerId']];

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
            $ticket->ticket_number = $id;

            return $ticket;
        }

        return null;
    }

    /**
     * Download the ticket PDF from sncf, and store it on S3
     * Also update ticket with the passbook_link
     */
    public function downloadAndReuploadPDF( Ticket $ticket )
    {

        /**
         * Temporarly deactivated.
         */
        return false;

        $referenceNumber = strtoupper( $ticket->provider_code );

        $url = str_replace( '{name}', $ticket->buyer_name, $this->retrieveURL );
        $url = str_replace( '{booking_code}', $referenceNumber, $url );

        foreach ( [ 'fr_FR', 'en_UK' ] as $country ) {

            $response = $this->client->request(
                'GET',
                str_replace( '{country}', $country, $url ),
                [ 'http_errors' => false ]
            );

            $decoded = json_decode( (string) $response->getBody(), true );

            if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS" ) {
                continue;
            } else {
                break;
            }
        }

        // Handle errors (if there isn't a trip from a station to another one)
        if ( $response->getStatusCode() != 200 ) {
            throw new PasseTonBilletException( 'Please try again later.' );
        }

        if ( ! isset( $decoded['status'] ) || $decoded['status'] != "SUCCESS" ) {
            throw new PasseTonBilletException( 'Nothing found with this name/code combination.' );
        }

        $decoded = json_decode( (string) $response->getBody(), true );

        // Find creation date and replace it
        $creationDate = $decoded['order']['trainFolders'][ $referenceNumber ]['creationDate'];
        $creationDate = str_replace( ':', '', $creationDate );
        $creationDate = str_replace( '-', '', $creationDate );
        $creationDate = str_replace( 'T', '', $creationDate );
        $creationDate = substr( $creationDate, 0, - 2 );

        $data = [
            "lang"    => "FR",
            "pnrRefs" => [
                [
                    "pnrLocator"    => $referenceNumber,
                    "creationDate"  => $creationDate,
                    "passengerName" => strtoupper( AppHelper::removeAccents( $ticket->buyer_name ) )
                ]
            ],
            "market"  => "VSC",
            "caller"  => "VSA_FR"
        ];

        // Now that we retrieved passenger id, we simply need to do a post to retrieve and download the ticket
        $response = $this->client->request(
            'POST',
            $this->pdfURL,
            [
                'body'    => json_encode( $data ),
                'headers' => [
                    'Accept'       => 'application/json, text/plain, */*',
                    'Content-Type' => 'application/json',
                    'Origin'       => 'https://www.oui.sncf',
                    'Referer'      => ' https://www.oui.sncf/monvoyage',
                ]
            ]
        );

        \Storage::disk( 's3' )->put( 'pdf/tickets/' . $ticket->pdf_file_name, (string) $response->getBody() );

        return true;

    }

}