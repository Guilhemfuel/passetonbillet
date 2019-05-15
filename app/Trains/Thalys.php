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
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use DiDom\Document;
use Spatie\Browsershot\Browsershot;

class Thalys extends TrainConnector
{
    private $retrieveURL;
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
                        'Ca'           => 'no-cache',
                        'Accept'       => '*/*',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Host'         => 'www.thalys.com',
                        'Connection'   => 'keep-alive',
                        'Origin'       => 'https://www.thalys.com',
                        'Referer'      => 'https://www.thalys.com/be/en/'
                    ],
                    'cookies' => true
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

        $response = $this->client->request( 'GET',
            $this->bookingURL,
            [
                'http_errors' => false,
            ] );


        $content = $response->getBody( true )->getContents();
        $document = new Document( $content );

        // Handle errors (if html containing data was not found)
        if ( ! $document->has( '.travel_wrapper' ) ) {
            throw new PasseTonBilletException( 'Please try again later.' );
        }

        $travelDataArray = $document->find( '.travel_wrapper' );
        $tickets = [];

        foreach ( $travelDataArray as $travelData ) {
            if ( ! $travelData->has( '.date_travel' ) ) {
                continue;
            }

            $tickets[] = $this->createTrainAndReturnTicket( $travelData, $lastName, $referenceNumber );

        }

        return $tickets;
    }

    private function createTrainAndReturnTicket( $travelData, $lastName, $referenceNumber, $past = false )
    {

        // Find date
        $date = $travelData->find( 'span.date_travel' )[0]->text();
        $date = substr( $date, 16 ); // String before date is 'Your journey on ` so 16 chars

        setlocale( LC_ALL, 'fr_FR' );
        Carbon::setLocale( 'fr' );
        $departureDate = Carbon::createFromFormat( 'l F d. Y', $date );
        $arrivalDate = $departureDate->copy();

        // Now find ticket information
        $ticketInfo = $travelData->find( '.travel.ticket-box' )[0];

        //Departure and arrival time
        $trip = $ticketInfo->find( '.od_wrapper' )[0];
        $lines = $trip->find( '.line' );

        $departureDate->setTimeFromTimeString( $lines[0]->find( '.time' )[0]->text() );
        $departureStation = $this->getTrainStation( $lines[0]->find( '.city' )[0]->text() );

        $arrivalDate->setTimeFromTimeString( $lines[1]->find( '.time' )[0]->text() );
        $arrivalStation = $this->getTrainStation( $lines[1]->find( '.city' )[0]->text() );

        if ( $departureStation == null ) {
            throw new PasseTonBilletException( 'Departure station not found.' );
        }
        if ( $arrivalStation == null ) {
            throw new PasseTonBilletException( 'Arrival station not found.' );
        }

        // Now we find ticket id
        $ticketId = $travelData->find( 'a.btn_popin_send_ticket_by_email' )[0];
        $ticketId = substr( $ticketId->getAttribute( 'id' ), 10 ); // Id starts with 'btn_popin_' (10 chars long)

        //  Train ID and class
        $tempInfoTravel = $travelData->find( '.travel_data' )[0]->find( '.wrapper_data' )[0]->find( 'p' )[1];
        $tempInfoTravel = explode( "\r\n", $tempInfoTravel->text() );

        $class = trim( $tempInfoTravel[1], ' ,' );
        $trainNumber = trim( $tempInfoTravel[2], ' ,' );

        // Retrieve price, currency and flexibility
        $tempInfoTravel = $ticketInfo->find( '.id_wrapper' )[0]->find( '.line_client' );
        $flexibility = $tempInfoTravel[1]->text();

        $price = floatval( preg_replace( '/\D/', '', $tempInfoTravel[2]->text() ) );

        switch ( substr( $tempInfoTravel[2]->text(), - 1 ) ) {
            case '$':
                $currency = 'USD';
                break;
            case '£':
                $currency = 'GBP';
                break;
            default:
                $currency = 'EUR';
        }

        // You can sell ticket max two hours before train!
        if ( $past || $departureDate->copy()->modify( '-2 hour' ) >= new \DateTime() ) {
            // We don't consider past tickets

            // Create train
            $train = Train::firstOrCreate(
                [
                    'number'         => $trainNumber,
                    'departure_date' => $departureDate->format( self::DATE_FORMAT_DB ),
                    'departure_time' => $departureDate->format( self::TIME_FORMAT_DB ),
                    'departure_city' => $departureStation->id,
                    'arrival_date'   => $arrivalDate->format( self::DATE_FORMAT_DB ),
                    'arrival_time'   => $arrivalDate->format( self::TIME_FORMAT_DB ),
                    'arrival_city'   => $arrivalStation->id
                ]
            );


            $boughtPrice = $price;

            // Create new Ticket
            $ticket = new Ticket();
            $ticket->train_id = $train->id;
            $ticket->flexibility = $flexibility;
            $ticket->class = $class;
            $ticket->bought_price = intval( $boughtPrice );
            $ticket->bought_currency = $currency;
            $ticket->inbound = false;
            $ticket->buyer_name = $lastName;
            $ticket->provider_code = $referenceNumber;
            $ticket->provider_id = $ticketId;
            $ticket->provider = self::PROVIDER;


            return $ticket;
        }

        return null;
    }

    /**
     * As we crawl a web page we don't have an id. This function finds the corresponding train station.
     *
     * @param $stationName
     *
     * @return Station
     */
    private function getTrainStation( string $stationName )
    {
        $stations = Station::whereIn( 'id', self::THALYS_STATIONS_ID )->get();

        $bestMatch = null;
        $matchValue = 0;

//        // Hard code Paris
//        if ( strpos( strtolower($stationName), 'paris'  ) !== false ) {
//            dd(Station::find(1129));
//            return Station::find(1129);
//
//        }

        // Otherwise find best match
        foreach ( $stations as $station ) {
            $tempMatchValue = 0;
            similar_text( $stationName, $station->name, $tempMatchValue );

            if ( $tempMatchValue > $matchValue ) {
                $matchValue = $tempMatchValue;
                $bestMatch = $station;
            }
        }

        return $bestMatch;
    }

    /**
     * Download the ticket PDF from Thalys, and store it on S3
     * Also update ticket with the passbook_link
     */
    public function downloadAndReuploadPDF( Ticket $ticket )
    {
        $url = $this->preparePDFurl;
        $url = str_replace( '{ticket_id}', $ticket->provider_id, $url );
        $url = str_replace( '{reference}', $ticket->provider_code, $url );
        $url = str_replace( '{name}', $ticket->buyer_name, $url );

        $jar = new CookieJar;

        // Prelimary request to get cookie
        $response = $this->client->request( 'GET',
            $url,
            [
                'http_errors' => false,
                'headers'     => [
                    'Accept-Encoding' => "gzip, deflate, br",
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36',
                ]
            ] );

        if ( $response->getStatusCode() != 200 ) {
            throw new PasseTonBilletException( 'Error during preliminary step to retrieve PDF.' );
        }

        // Now get pdf
        $response = $this->client->request( 'GET',
            $this->pdfUrl,
            [
                'http_errors' => false,
                'headers'     => [
                    'Accept-Encoding' => "gzip, deflate, br",
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36',
                ]
            ] );


        $html = mb_convert_encoding( $response->getBody( true )->getContents(), 'HTML-ENTITIES', 'UTF-8' );

        $pdf = Browsershot::html( $html )->emulateMedia('print')->pdf();

        \Storage::disk( 's3' )->put( 'pdf/tickets/' . $ticket->pdf_file_name, (string) $pdf );

        return true;
    }

}