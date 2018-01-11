<?php

namespace Tests\Feature;

use App\EurostarAPI\Eurostar;
use App\Exceptions\LastarException;
use App\Station;
use App\Train;
use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use phpDocumentor\Reflection\Types\Boolean;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EurostarTest extends TestCase
{

    private $familyName = 'nahum';

    private $bookingCode = 'ROCLRR';

    private $bookingInfo = array(
        'ROCLRR-nahum' =>
            array(
                'LoadTravelOutput' =>
                    array(
                        'contact'                     =>
                            array(
                                'title'       => 'Mr',
                                'firstName'   => 'JULIEN',
                                'lastName'    => 'NAHUM',
                                'email'       => 'TRAVEL@NAHUM.NET',
                                'phoneNumber' => '447397515743',
                                'address'     =>
                                    array(
                                        'address'  => 'FLAT 13 STANHOPE APARTMENT 70 STANHOPESTREET',
                                        'city'     => 'LONDON',
                                        'country'  => 'GB',
                                        'postCode' => 'NW1 3EX',
                                    ),
                            ),
                        'currency'                    => 'GBP',
                        'JourneyRetrievePnrOutputs'   =>
                            array(
                                0 =>
                                    array(
                                        'id'                => 1,
                                        'destinationCode'   => 7015400,
                                        'originCode'        => 8727100,
                                        'arrivalDate'       =>
                                            array(
                                                'date' => '11/07/2017',
                                                'time' => '10:00',
                                            ),
                                        'departureDate'     =>
                                            array(
                                                'date' => '11/07/2017',
                                                'time' => '08:43',
                                            ),
                                        'FareAllocations'   =>
                                            array(
                                                0 =>
                                                    array(
                                                        'fareInformation'   =>
                                                            array(
                                                                'classOfService'            => 'BF',
                                                                'eligibilityChangeMeal'     => false,
                                                                'eligibilityChangeSeat'     => false,
                                                                'eligibilityExchange'       => false,
                                                                'eligibilityForcedExchange' => false,
                                                                'eligibilityForcedRefund'   => false,
                                                                'eligibilityRefund'         => false,
                                                                'eligibilityUpgrade'        => false,
                                                                'fareCode'                  => 'BFPESARB',
                                                                'flexibilityLevel'          => 2,
                                                                'maskedPrice'               => false,
                                                                'totalAmount'               => 160,
                                                                'cm'                        => '',
                                                            ),
                                                        'CheckedInTickets'  =>
                                                            array(
                                                                0 =>
                                                                    array(
                                                                        'checkedIn'   => true,
                                                                        'passengerId' => 'ROCLRR.1.1',
                                                                        'segmentId'   => 1,
                                                                    ),
                                                            ),
                                                        'PassengerIds'      =>
                                                            array(
                                                                0 => 'ROCLRR.1.1',
                                                            ),
                                                        'passengerTypeCode' => 'PT01AD',
                                                        'SegmentIds'        =>
                                                            array(
                                                                0 => '1',
                                                            ),
                                                        'tcn'               => '506326063',
                                                    ),
                                            ),
                                        'outboundIndicator' => true,
                                        'TravelSegments'    =>
                                            array(
                                                0 =>
                                                    array(
                                                        'id'                    => 1,
                                                        'duration'              => 137,
                                                        'startDate'             =>
                                                            array(
                                                                'date' => '11/07/2017',
                                                                'time' => '08:43',
                                                            ),
                                                        'endDate'               =>
                                                            array(
                                                                'date' => '11/07/2017',
                                                                'time' => '10:00',
                                                            ),
                                                        'marketingCarrierCode'  => 'ES',
                                                        'marketingTrainNumber'  => '9013',
                                                        'classOfAccommodation'  => 'B',
                                                        'disruptionInformation' =>
                                                            array(
                                                                'impactedByDisruption' => false,
                                                            ),
                                                        'MealAvailables'        => null,
                                                        'MethodOfDeliverys'     =>
                                                            array(
                                                                0 =>
                                                                    array(
                                                                        'codeMethod' => 'MTK',
                                                                    ),
                                                                1 =>
                                                                    array(
                                                                        'codeMethod' => 'PAH',
                                                                    ),
                                                                2 =>
                                                                    array(
                                                                        'codeMethod' => 'TOD',
                                                                    ),
                                                            ),
                                                        'od'                    =>
                                                            array(
                                                                'originCode'      => '8727100',
                                                                'destinationCode' => '7015400',
                                                            ),
                                                    ),
                                            ),
                                    ),
                                1 =>
                                    array(
                                        'id'                => 2,
                                        'destinationCode'   => 8727100,
                                        'originCode'        => 7015400,
                                        'arrivalDate'       =>
                                            array(
                                                'date' => '07/09/2017',
                                                'time' => '19:47',
                                            ),
                                        'departureDate'     =>
                                            array(
                                                'date' => '07/09/2017',
                                                'time' => '16:31',
                                            ),
                                        'FareAllocations'   =>
                                            array(
                                                0 =>
                                                    array(
                                                        'fareInformation'   =>
                                                            array(
                                                                'classOfService'            => 'BJ',
                                                                'eligibilityChangeMeal'     => false,
                                                                'eligibilityChangeSeat'     => true,
                                                                'eligibilityExchange'       => false,
                                                                'eligibilityForcedExchange' => false,
                                                                'eligibilityForcedRefund'   => false,
                                                                'eligibilityRefund'         => false,
                                                                'eligibilityUpgrade'        => true,
                                                                'fareCode'                  => 'BJPEXARB',
                                                                'flexibilityLevel'          => 2,
                                                                'maskedPrice'               => false,
                                                                'totalAmount'               => 34,
                                                                'cm'                        => '',
                                                            ),
                                                        'CheckedInTickets'  =>
                                                            array(
                                                                0 =>
                                                                    array(
                                                                        'checkedIn'   => false,
                                                                        'passengerId' => 'ROCLRR.1.1',
                                                                        'segmentId'   => 2,
                                                                    ),
                                                            ),
                                                        'PassengerIds'      =>
                                                            array(
                                                                0 => 'ROCLRR.1.1',
                                                            ),
                                                        'passengerTypeCode' => 'PT01AD',
                                                        'SegmentIds'        =>
                                                            array(
                                                                0 => '2',
                                                            ),
                                                        'tcn'               => '506326074',
                                                    ),
                                            ),
                                        'outboundIndicator' => false,
                                        'TravelSegments'    =>
                                            array(
                                                0 =>
                                                    array(
                                                        'id'                    => 2,
                                                        'duration'              => 136,
                                                        'startDate'             =>
                                                            array(
                                                                'date' => '07/09/2017',
                                                                'time' => '16:31',
                                                            ),
                                                        'endDate'               =>
                                                            array(
                                                                'date' => '07/09/2017',
                                                                'time' => '19:47',
                                                            ),
                                                        'marketingCarrierCode'  => 'ES',
                                                        'marketingTrainNumber'  => '9040',
                                                        'classOfAccommodation'  => 'B',
                                                        'disruptionInformation' =>
                                                            array(
                                                                'impactedByDisruption' => false,
                                                            ),
                                                        'MealAvailables'        =>
                                                            array(
                                                                0 =>
                                                                    array(
                                                                        'mealCode' => 'CHML',
                                                                    ),
                                                                1 =>
                                                                    array(
                                                                        'mealCode' => 'DBML',
                                                                    ),
                                                                2 =>
                                                                    array(
                                                                        'mealCode' => 'DFML',
                                                                    ),
                                                                3 =>
                                                                    array(
                                                                        'mealCode' => 'GFML',
                                                                    ),
                                                                4 =>
                                                                    array(
                                                                        'mealCode' => 'KSML',
                                                                    ),
                                                                5 =>
                                                                    array(
                                                                        'mealCode' => 'LFML',
                                                                    ),
                                                                6 =>
                                                                    array(
                                                                        'mealCode' => 'LSML',
                                                                    ),
                                                                7 =>
                                                                    array(
                                                                        'mealCode' => 'MOML',
                                                                    ),
                                                                8 =>
                                                                    array(
                                                                        'mealCode' => 'VGML',
                                                                    ),
                                                                9 =>
                                                                    array(
                                                                        'mealCode' => 'VLML',
                                                                    ),
                                                            ),
                                                        'MethodOfDeliverys'     =>
                                                            array(
                                                                0 =>
                                                                    array(
                                                                        'codeMethod' => 'MTK',
                                                                    ),
                                                                1 =>
                                                                    array(
                                                                        'codeMethod' => 'PAH',
                                                                    ),
                                                                2 =>
                                                                    array(
                                                                        'codeMethod' => 'TOD',
                                                                    ),
                                                            ),
                                                        'od'                    =>
                                                            array(
                                                                'originCode'      => '7015400',
                                                                'destinationCode' => '8727100',
                                                            ),
                                                    ),
                                            ),
                                    ),
                            ),
                        'Pnrs'                        =>
                            array(
                                0 => 'ROCLRR',
                            ),
                        'LinkedPnrs'                  =>
                            array(),
                        'PassengerRetrievePnrOutputs' =>
                            array(
                                0 =>
                                    array(
                                        'eftNumber'                        => null,
                                        'id'                               => 'ROCLRR.1.1',
                                        'notAllowedToTravelAlonePassenger' => false,
                                        'passengerType'                    => 'ADULT',
                                        'pnrReference'                     => 'ROCLRR',
                                        'SeatRetrievePnrOutputs'           =>
                                            array(
                                                0 =>
                                                    array(
                                                        'coachNumber' => 7,
                                                        'seatNumber'  => 33,
                                                        'segmentId'   => 2,
                                                    ),
                                            ),
                                        'trueName'                         =>
                                            array(
                                                'firstName' => 'Julien',
                                                'lastName'  => 'Nahum',
                                            ),
                                        'wheelchair'                       => false,
                                    ),
                            ),
                        'paymentInformation'          =>
                            array(
                                'CreditCardTransactions' =>
                                    array(
                                        'CreditCardTransaction' =>
                                            array(
                                                0 =>
                                                    array(
                                                        'actionDate'          =>
                                                            array(
                                                                'date' => '10/07/2017',
                                                                'time' => '12:23',
                                                            ),
                                                        'amount'              => 194,
                                                        'cardScheme'          => 'VISA Debit',
                                                        'creditCardSurcharge' => 0,
                                                        'expiryDate'          =>
                                                            array(
                                                                'date' => '10/07/2017',
                                                                'time' => '12:23',
                                                            ),
                                                        'pspTransactionId'    => '3300106980330184',
                                                        'tokenCreditCard'     => '9014711767570989141',
                                                    ),
                                            ),
                                    ),
                            ),
                        'pointOfSale'                 => null,
                        'totalPrice'                  => 194,
                    ),
            ),
    );

    /**
     *
     * Test that family name and code can retrieve one ticket
     * Only one ticket in this booking for a future day
     *
     */

    public function testRetrieveTicket()
    {
        // Set only one ticket
        $customTicketsList = &$this->bookingInfo[ $this->bookingCode . '-' . $this->familyName ]['LoadTravelOutput']['JourneyRetrievePnrOutputs'];
        while ( count( $customTicketsList ) > 1 ) {
            unset( $customTicketsList[count( $customTicketsList )-1] );
        }
        // Give the ticket a proper date and info
        $tomorrow = new \DateTime( 'tomorrow' );
        $customTicketsList[0]['departureDate']['date'] = $tomorrow->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['arrivalDate']['date'] = $tomorrow->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['FareAllocations'][0]['fareInformation']['classOfService'] = 'BJ';

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $this->bookingInfo ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $ticket = $tickets[0];
        $this->assertEquals( 1, count( $tickets ) );
        $this->assertEquals( 'BJ', $ticket->class );
        $this->assertEquals( $this->bookingCode, $ticket->eurostar_code );
    }


    /**
     *
     * Test that retrieved tickets have a proper 24-time format saved
     *
     */

    public function testRetrieveTicketAllDay()
    {
        // Set only one ticket
        $customTicketsList = &$this->bookingInfo[ $this->bookingCode . '-' . $this->familyName ]['LoadTravelOutput']['JourneyRetrievePnrOutputs'];
        while ( count( $customTicketsList ) > 1 ) {
            unset( $customTicketsList[count( $customTicketsList )-1] );
        }
        // Give the ticket a proper date and info
        $tomorrow = new \DateTime( 'tomorrow' );
        $tomorrow->setTime(14, 55);
        $customTicketsList[0]['departureDate']['date'] = $tomorrow->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['departureDate']['time'] = $tomorrow->format(Eurostar::TIME_FORMAT_JSON);
        $customTicketsList[0]['arrivalDate']['date'] = $tomorrow->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['FareAllocations'][0]['fareInformation']['classOfService'] = 'BJ';

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $this->bookingInfo ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $ticket = $tickets[0];
        $this->assertEquals( 1, count( $tickets ) );
        $this->assertEquals( 'BJ', $ticket->class );
        $this->assertEquals( $this->bookingCode, $ticket->eurostar_code );
        $this->assertEquals(  $tomorrow->format('H:i:s'), $ticket->train->departure_time);
    }

    /**
     *
     * If on ticket is passed it is returned
     * Two tickets, one passed one future (only future retrieved)
     *
     */

    public function testRetrieveTicketPassed()
    {
        // Set only one ticket
        $customTicketsList = &$this->bookingInfo[ $this->bookingCode . '-' . $this->familyName ]['LoadTravelOutput']['JourneyRetrievePnrOutputs'];
        while ( count( $customTicketsList ) > 1 ) {
            unset( $customTicketsList[count( $customTicketsList )-1] );
        }
        // Give the ticket a proper date
        $tomorrow = new \DateTime( 'tomorrow' );
        $yesterday = new \DateTime( 'yesterday' );
        $customTicketsList[0]['departureDate']['date'] = $tomorrow->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['arrivalDate']['date'] = $tomorrow->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['FareAllocations'][0]['fareInformation']['classOfService'] = 'BJ';
        // Add a past ticket
        array_push( $customTicketsList, $customTicketsList[0]);
        $customTicketsList[0]['departureDate']['date'] = $yesterday->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['arrivalDate']['date'] = $yesterday->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['FareAllocations'][0]['fareInformation']['classOfService'] = 'BJ';


        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $this->bookingInfo ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $ticket = $tickets[0];
        $this->assertEquals( 1, count( $tickets ) ,'Two tickets were retrieved instead of one');
        $this->assertEquals( $this->bookingCode, $ticket->eurostar_code );
    }


    /**
     *
     * One ticket in booking, but is passed
     *
     */
    public function testRetrieveTicketNoTicket()
    {
        // Set only one ticket
        $customTicketsList = &$this->bookingInfo[ $this->bookingCode . '-' . $this->familyName ]['LoadTravelOutput']['JourneyRetrievePnrOutputs'];
        while ( count( $customTicketsList ) > 1 ) {
            unset( $customTicketsList[count( $customTicketsList )-1] );
        }
        // Give the ticket a proper date and info
        $yesterday = new \DateTime( 'yesterday' );
        $customTicketsList[0]['departureDate']['date'] = $yesterday->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['arrivalDate']['date'] = $yesterday->format(Eurostar::DATE_FORMAT_JSON);
        $customTicketsList[0]['FareAllocations'][0]['fareInformation']['classOfService'] = 'BJ';

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $this->bookingInfo ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $this->assertEquals( 0, count( $tickets ) );
    }

    /**
     *
     * Check that retrieve tickets throws Lastar exception in case of eurostar error
     *
     */
    public function testRetrieveTicketError()
    {
        $this->expectException( LastarException::class );

        // Mock client
        $mock = new MockHandler( [
            new Response( 500, [], \GuzzleHttp\json_encode( $this->bookingInfo ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );
    }

}
