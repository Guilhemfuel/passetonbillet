<?php

namespace App\ApiConnectors;

use App\Exceptions\PasseTonBilletException;
use GuzzleHttp\Client;


/**
 * Class Optico
 * @package App\ApiConnectors
 *
 * Used to interface with the optico api.
 */
class Optico
{
    private $client;
    private $apiKey;
    private $paidPhoneUrl;

    /**
     * Optico constructor.
     *
     * @param Client|null $customClient
     *
     * Create the custom client for the connector with pre-defined headers.
     */
    public function __construct( Client $customClient = null )
    {
        $this->apiKey = config('api-connectors.optico.api_key');
        $this->paidPhoneUrl = config('api-connectors.optico.paid_phone_url');

        if ( $customClient ) {
            $this->client = $customClient;

            return;
        }

        $this->client = new Client( [
            'headers' => [
                'Content-type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ] );

    }

    /**
     * Given a phone number in a string, returns a Paid phone number redirecting to that number.
     *
     * @param $number
     *
     * @throws PasseTonBilletException
     */
    public function getPaidPhoneNumber( $number )
    {

        // Make sure that $number is a string
        if(!is_string($number)) {
            throw new PasseTonBilletException("Phone number must be a string. ".typeOf($number). " given.");
        }

        // Make sure that $number is valid
        if(!preg_match("/[0-9]/", $number)) {
            throw new PasseTonBilletException("Phone numbers must contain numbers only.");
        }

        // Perform request
        $options = [
            'form_params' => [
                'api_key' => $this->apiKey,
                'phone' => $number,
            ],
        ];
        $response = $this->client->post($this->paidPhoneUrl, $options);

        if (!$response->getStatusCode() == 200) {
            throw new PasseTonBilletException("Request failed.");
        }

        $data = json_decode( (string) $response->getBody(), true );
        $phone = $data['surtaxPhone']['surtaxPhoneNumber'];

        return $phone;

    }

}