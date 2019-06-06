<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 11/05/2019
 * Time: 16:50
 */

namespace App\Trains;

use GuzzleHttp\Client;

/**
 * Default train connector class to extend.
 *
 * Class TrainConnector
 * @package App\Trains
 */
abstract class TrainConnector
{
    const PROVIDERS = [
        'eurostar',
        'thalys',
        'sncf',
        'ouigo'
    ];

    /**
     * Providers using name + PNR
     */
    const CLASSIC_PROVIDERS = [
        'eurostar',
        'thalys',
        'sncf'
    ];

    /**
     * Http client used for the requests of the connectors
     *
     * @var
     */
    protected $client;

    /**
     * Type of the connector (what information it uses)
     *
     * @var
     */
    protected $type;

    public abstract function __construct( Client $customClient = null );

    /**
     *
     * Takes booking information and returns tickets.
     *
     * @param $lastName
     * @param $referenceNumber
     *
     * @return array
     */
    public abstract function retrieveTicket( $email, $lastName, $referenceNumber, $past = false );

}