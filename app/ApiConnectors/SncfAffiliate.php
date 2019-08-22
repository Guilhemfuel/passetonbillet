<?php

namespace App\ApiConnectors;

use App\Exceptions\PasseTonBilletException;
use App\Http\Resources\StationRessource;
use App\Station;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;


/**
 * Class Optico
 * @package App\ApiConnectors
 *
 * Used to interface with the oui sncf affiliate api.
 */
class SncfAffiliate
{
    private $client;
    private $apiKey;
    private $url;

    public $departureStation;
    public $arrivalStation;

    const AFFILIATE_TYPE = 'oui_sncf';

    /**
     * SncfAffiliate constructor.
     *
     * @param Client|null $customClient
     *
     * Create the custom client for the connector with pre-defined headers.
     */
    public function __construct( Client $customClient = null )
    {
        $this->apiKey = config( 'api-connectors.sncf_affiliate.api_key' );
        $this->url = config( 'api-connectors.sncf_affiliate.url' );

        if ( $customClient ) {
            $this->client = $customClient;

            return;
        }

        $this->client = new Client( [
            'headers' => [
                'Content-type' => 'application/json',
                'Accept'       => 'application/json',
                'apikey'       => $this->apiKey
            ],
        ] );

    }

    /**
     * Given a trip and a date, return scnf proposals with
     *
     * @throws PasseTonBilletException
     */
    public function getProposals( Station $departureStation, Station $arrivalStation, Carbon $date, $time = null, $quantity = 3 )
    {
        // If station can't be used for API (no sncf_id)
        if ( $departureStation->sncf_id == null || $arrivalStation->sncf_id == null ) {
            return [];
        }

        $this->departureStation = $departureStation;
        $this->arrivalStation = $arrivalStation;

        $url = str_replace( [ '{departure}', '{arrival}', '{date}' ],
            [ $departureStation->sncf_id, $arrivalStation->sncf_id, $date->format( 'Y-m-d' ) ],
            $this->url );

        try {
            $response = $this->client->get( $url, [
                'headers' => [
                    'apikey' => $this->apiKey
                ]
            ] );
        } catch (\Exception $exception) {
            return [];
        }

        if ( ! $response->getStatusCode() == 200 ) {
            return [];
        }

        $data = json_decode( (string) $response->getBody(), true )['outwards'];
        $proposals = $this->parseResponse( $data );

        $proposals = $this->filterProposals( $proposals, $time, $quantity );

        return $proposals;

    }

    /**
     * Filter proposals to return the cheapest options.
     * TODO: filter sncf results to include time constraints if possible.
     *
     * @param $proposals
     *
     * @return array
     */
    protected function filterProposals( $proposals, $time, $quantity )
    {

        // Sort proposals
        usort( $proposals, function ( $a, $b ) {
            return $a['price'] <=> $b['price'];
        } );

        // Take required quantity
        $proposals = array_slice( $proposals, 0, $quantity );

        // Finally resort by time
        usort( $proposals, function ( $a, $b ) {
            return $a['departure_date'] <=> $b['departure_date'];
        } );

        return $proposals;
    }

    /**
     * Parse response to get all the proposals in the format we need.
     *
     * @param $data
     *
     * @return array
     */
    protected function parseResponse( $data )
    {

        $proposals = [];

        foreach ( $data as $entity ) {
            $proposals[] = [
                'id'             => $entity['uid'],
                'link'           => $this->transformUrl( $entity['deeplinks']['FR'] ),
                'departure_date' => $entity['departureDate'],
                'arrival_date'   => $entity['arrivalDate'],
                'duration'       => $this->computeDuration( $entity['departureDate'], $entity['arrivalDate'], $entity['duration'] ),
                'departure_city' => ( new StationRessource( $this->departureStation ) )->toArray( request() ),
                'arrival_city'   => ( new StationRessource( $this->arrivalStation ) )->toArray( request() ),
                'price'          => (int) ( $entity['price'] / 100 ),
                'stock'          => $entity['stock'],
                'type'           => self::AFFILIATE_TYPE
            ];
        }

        return $proposals;
    }

    /**
     * Transform url to add trade doubler tracking
     */
    protected function transformUrl( $url )
    {
        $tradeDoublerUrl = config( 'api-connectors.sncf_affiliate.tradedoubler_url' );

        return $tradeDoublerUrl . '&url=' . urlencode( $url );
    }

    /**
     * Compute exact duration, taking care of timezone issues
     *
     * @param $departureDare
     * @param $arrivalDate
     */
    protected function computeDuration( $departureDate, $arrivalDate, $fallback = null )
    {

        try {
            $departureDate = Carbon::createFromFormat( 'Y-m-d\TH:i:s', $departureDate, $this->departureStation->timezone );
            $arrivalDate = Carbon::createFromFormat( 'Y-m-d\TH:i:s', $arrivalDate, $this->arrivalStation->timezone );

            return $departureDate->diffInMinutes( $arrivalDate );
        } catch ( \Exception $e ) {
            //
        }

        return $fallback;
    }

}