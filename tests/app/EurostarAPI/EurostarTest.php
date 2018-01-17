<?php

namespace Tests\Feature;

use App\EurostarAPI\Eurostar;
use App\Exceptions\LastarException;
use App\Station;
use App\Ticket;
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

    private $bookingCode = 'RTXYUS';

    private $ticketData = array(
        'info'      =>
            array(
                'origin'               =>
                    array(
                        'code'           => '8727100',
                        'description'    => 'Paris Gare Du Nord',
                        'latitude'       => '48.880783',
                        'longitude'      => '2.354497',
                        'marketingGroup' => null,
                        'abs'            => false,
                        'ags'            => false,
                        'ads'            => false,
                    ),
                'destination'          =>
                    array(
                        'code'           => '7015400',
                        'description'    => 'Londres St Pancras Int\'l',
                        'latitude'       => '51.53079647',
                        'longitude'      => '-0.125557924',
                        'marketingGroup' => null,
                        'abs'            => false,
                        'ags'            => false,
                        'ads'            => false,
                    ),
                'departureDate'        => '2018-02-09',
                'departureTime'        => '20:01',
                'arrivalDate'          => '2018-02-09',
                'arrivalTime'          => '21:39',
                'duration'             => 158,
                'trainNumber'          => '9059',
                'equipmentType'        => 'TGR',
                'carrierCode'          => 'ES',
                'classOfAccommodation' =>
                    array(
                        'code'        => 'B',
                        'description' => 'Standard',
                    ),
                'printingOptions'      =>
                    array(
                        0 => 'MTK',
                        1 => 'PAH',
                        2 => 'TOD',
                    ),
                'impactedByDisruption' => false,
            ),
        'seat'      =>
            array(
                'coachNumber' => '011',
                'seatNumber'  => '052',
                'meal'        => null,
            ),
        'checkedIn' => false,
        'fare'      =>
            array(
                'fareCode'                  => 'BIPEXARB',
                'classOfService'            => 'BI',
                'passengerTypeCode'         => 'PT01AD',
                'eligibilityChangeMeal'     => false,
                'eligibilityChangeSeat'     => true,
                'eligibilityExchange'       => true,
                'eligibilityForcedExchange' => false,
                'eligibilityForcedRefund'   => false,
                'eligibilityRefund'         => false,
                'eligibilityUpgrade'        => true,
                'flexibilityLevel'          => '2',
                'maskedPrice'               => false,
                'totalFarePrice'            => '34.0',
                'tcn'                       => '382007242',
            ),
        'transfer'  => null,
    );

    private $bookingInfo = array(
        'booking' =>
            array(
                'pnr'                 => 'RTXYUS',
                'splitPnrs'           =>
                    array(
                        0 => 'RTXYUS',
                    ),
                'pos'                 => 'GBZXB',
                'totalPrice'          => '68.0',
                'currency'            => 'EUR',
                'payment'             =>
                    array(
                        'transactionDate' => '2018-01-03',
                        'transactionTime' => '11:19',
                        'card'            =>
                            array(
                                'cardType'            => 'Mastercard',
                                'dataCashReferenceId' => '3900107684148944',
                                'expiryDate'          => '1120',
                                'token'               => '9713163804383316350',
                                'totalPayment'        => '68.0',
                                'fee'                 => '0.0',
                            ),
                        'vouchers'        => null,
                    ),
                'ancillaries'         => null,
                'contact'             =>
                    array(
                        'address'     =>
                            array(
                                'address'  => 'WITLEY COURT, CORAM STREET, FLAT 17 WITLEY COURT, CORAM STREET, FLAT 17',
                                'city'     => 'LONDON',
                                'country'  => 'GB',
                                'postcode' => 'WC1N 1HD',
                            ),
                        'email'       => 'ACHAT335@NAHUM.NET',
                        'emailHash'   => '501675298ffd1ff54ee701d3008bb2e3a6be7404358e4957e7e9a3e6d20f8b27',
                        'firstName'   => 'JULIEN',
                        'lastName'    => 'NAHUM',
                        'phoneNumber' => '33447397515743',
                        'title'       => 'Mr',
                    ),
                'passengers'          =>
                    array(
                        0 =>
                            array(
                                'id'                               => 'RTXYUS.1.1',
                                'firstName'                        => 'Julien',
                                'lastName'                         => 'Nahum',
                                'passengerType'                    => 'ADULT',
                                'wheelchair'                       => false,
                                'notAllowedToTravelAlonePassenger' => false,
                                'eftNumber'                        => '30838110033480460',
                                'outbound'                         => null,
                                'outboundDuration'                 => 158,
                                'inbound'                          => null,
                                'inboundDuration'                  => 136,
                                'ctrReference'                     => null,
                            ),
                    ),
                'isReturn'            => false,
                'pastDeparture'       => false,
                'manageBookingOnline' => true,
                'cid'                 => 'mobile-cid',
                'language'            => 'fr-fr',
                'paymentHistory'      =>
                    array(
                        0 =>
                            array(
                                'transactionDate' => '03/01/2018',
                                'transactionTime' => '11:19',
                                'card'            =>
                                    array(
                                        'cardType'            => 'Mastercard',
                                        'dataCashReferenceId' => '3900107684148944',
                                        'expiryDate'          => '1120',
                                        'token'               => '9713163804383316350',
                                        'totalPayment'        => '68.0',
                                        'fee'                 => '0.0',
                                    ),
                                'vouchers'        =>
                                    array(),
                            ),
                    ),
                'etapDetailsCaptured' => 'CAPTURED',
                'etapBooking'         =>
                    array(
                        'pnr'                 => 'RTXYUS',
                        'detailsCaptured'     => 'CAPTURED',
                        'passengers'          =>
                            array(
                                0 =>
                                    array(
                                        'id'              => 'd31675eb36da8f6e0c38a9b92416c8f9',
                                        'type'            => 'ADULT',
                                        'firstName'       => 'Julien',
                                        'lastName'        => 'Nahum',
                                        'email'           => 'ACHAT335@NAHUM.NET',
                                        'phone'           =>
                                            array(
                                                'countryCode' => '33',
                                                'number'      => '447397515743',
                                            ),
                                        'cin'             => null,
                                        'optIn'           => false,
                                        'detailsCaptured' => 'CAPTURED',
                                        'groupDetails'    => null,
                                        'infant'          => null,
                                    ),
                            ),
                        'infants'             =>
                            array(),
                        'eligibleTicketTypes' =>
                            array(
                                0 => 'MOBILE',
                                1 => 'PAH',
                                2 => 'TOD',
                                3 => 'PASSBOOK',
                                4 => 'PDF417',
                            ),
                        'splitPNRs'           =>
                            array(),
                        'linkedPNRs'          =>
                            array(),
                        'splitBookings'       =>
                            array(),
                        'linkedBookings'      =>
                            array(),
                        'groupName'           => null,
                        'accessToken'         => '618f2e22-765d-4664-bde7-5dcd35363448',
                        'ticketsData'         =>
                            array(
                                'tickets'  =>
                                    array(
                                        0 =>
                                            array(
                                                'passengerId'   => 'd31675eb36da8f6e0c38a9b92416c8f9',
                                                'firstName'     => 'Julien',
                                                'lastName'      => 'Nahum',
                                                'direction'     => 'OUTBOUND',
                                                'url'           => 'https://tickets.eurostar.com/tickets/RTXYUS/83e30c53-4404-459e-ad24-7633d4bce2cb.png?response-content-type=image%2Fpng&AWSAccessKeyId=AKIAIS4OAMU4IZGEPEAQ&Expires=1519242420&Signature=Uh0B2VFoBZBPrmwQC61izqvMu4k%3D',
                                                'type'          => 'PDF417',
                                                'language'      => 'en',
                                                'barcodeString' => 'eRIVRTXYUS382007242111130019000011001008003040221FRPNOGBSPX09059 90590400110522    BIAAIWHGBASFCUJRJACFDCUSHJTVTTGWVCFDBJREJRWUBSFJTJFRIICHUVSTSWSJCIBAGUDREFHJFHTGHBWH',
                                                'barcodeImage'  => 'iVBORw0KGgoAAAANSUhEUgAAAd4AAABgAQAAAACbUi7fAAABjUlEQVR42u3XMaooMQgFUMFWcCsBW8GtC7aBbEWwFXx5r/38BQSmmOYmp3PuOACwj++0PDU024IzOFpO9eq2ILuRnYyu0b9zFqtxODvhw29huadzUDGX8LLjtC2hlt4rhkvNN3MetAZZBnKDD7+HQxqKw1UWDgqwk8+SBf0bkCqEOKco6E4eMf/wi3g7wR0BaPY9ZscO6SRSktoehKh9+gbixLYZNT/8Io5lVZTQx5mBDv6VgWA0So0Asc++olhxTMh7Pvwg9g2VEZcMjOG2o261Gm5H4FlctVGnxK0LHWFDfPhBvFO5bgl0DyLyiROYhWnKEbcCmsPYk0yJ7g4grvjhB7Gjenba7saj647Aill4d3esiL+tru6kYPld3dHozsmH38QkqUsjG9d9QvLeHKJWRSiofb/pGcc1GAbEz4cfxLstS9WatO+/dtbJ1mpjHY7zTyBJ+OEHcdzOL6BoxzUL7kSA8P8DSp0PP4h3K2T/vvKghXdb35Cr0p3G5YALnCvkEPRiNbgd8eG38A8GDytGiudm6gAAAABJRU5ErkJggg==',
                                                'ticketNumber'  => '382007242',
                                            ),
                                        1 =>
                                            array(
                                                'passengerId'   => 'd31675eb36da8f6e0c38a9b92416c8f9',
                                                'firstName'     => 'Julien',
                                                'lastName'      => 'Nahum',
                                                'direction'     => 'INBOUND',
                                                'url'           => 'https://tickets.eurostar.com/tickets/RTXYUS/a304c905-d5b9-4649-9fe2-138205646e7b.png?response-content-type=image%2Fpng&AWSAccessKeyId=AKIAIS4OAMU4IZGEPEAQ&Expires=1519242420&Signature=xH6Iz6NOO7S05xUDVf2ggWJIHmI%3D',
                                                'type'          => 'PDF417',
                                                'language'      => 'en',
                                                'barcodeString' => 'eRIVRTXYUS382007253111130019000011001008003050231GBSPXFRPNO09040 90400500040322    BIAAIWWHGBFDJBWJAEVTWVWUHTJEUJTSDRDAWWTTCIITHWTGIBVCCCRRVGJAVVBSGRAUEHICRBWFWUWWBDGW',
                                                'barcodeImage'  => 'iVBORw0KGgoAAAANSUhEUgAAAd4AAABgAQAAAACbUi7fAAABjUlEQVR42u3XMaogMQgAUMFW8CqBtIJXF2yFXEWwFfz5u+WyBwhMEYaYvM6oAwBxLFLz1NCEOqez9z7Vq1ud9Ib0pHeN/DnnrTUGJxI+/Bbe93QOCubavPQYhSbUkmOquEQtmPOgNuylsG/gw+9h3w3FbrIXDm5gI5u1F/RvgETAt3Ht5I7k2WoffhGHEeTxFLaj+4w64t2ZEZ9goj1xepIONFkiSn74RexLqyihDzBC9PwtBpFy12wgtokrigVHN1nPhx/EFlDpfsnACKJZGSWZynFjKuNQhoqFvfg4BPiHH8Q3G7jSlsxqvY3bXTvzznCSzUzM6mvdG3la1G8DEPzwg9hQ7Nb4dfMDC9vS9uwMbAm4M9vRdodO1CIIRTKED7+JafduSlmqJzDu1L4k71ewfouBuUBO/JaIHth2PvwgjtYsReu8Vj3rZEu1sgz7+Sewk/DDD2K/Nb+AvA3XrPveAzb/P3BzaT78II6+T/3+f4eClHCnK1CB32unGW478Egs96TiRKCWD7+FfwBZQGCGufekXgAAAABJRU5ErkJggg==',
                                                'ticketNumber'  => '382007253',
                                            ),
                                    ),
                                'passbook' =>
                                    array(
                                        382007242 => 'https://passbook.eurostar.com/pass/2018-01-10/fe9894f3-c659-4590-945c-9de8fe9bef77.pkpass?response-content-type=application%2Fvnd.apple.pkpass&AWSAccessKeyId=AKIAJOBZJPTO6OSKQKXA&Expires=1547137928&Signature=rKBb5u2ZN%2Br6bzo5UonYANEhQkU%3D',
                                        382007253 => 'https://passbook.eurostar.com/pass/2018-01-10/61ef7957-eea6-4ac0-b95a-912bfbbac153.pkpass?response-content-type=application%2Fvnd.apple.pkpass&AWSAccessKeyId=AKIAJOBZJPTO6OSKQKXA&Expires=1547137928&Signature=CkCot5%2BAoEhMa8CG9p7lzFX9u88%3D',
                                    ),
                            ),
                    ),
            ),
    );

    private function createTicketDataset( $train, $ticket )
    {
        $dataSet1 = $this->ticketData;
        $dataSet1['info']['trainNumber'] = $train->number;
        $dataSet1['info']['departureDate'] = $train->departure_date;
        $dataSet1['info']['departureTime'] = $train->departure_time;
        $dataSet1['info']['arrivalDate'] = $train->arrival_date;
        $dataSet1['info']['arrivalTime'] = $train->arrival_time;
        $dataSet1['info']['origin']['code'] = $train->departureCity->eurostar_id;
        $dataSet1['info']['destination']['code'] = $train->arrivalCity->eurostar_id;
        $dataSet1['fare']['flexibilityLevel'] = $ticket->flexibility;
        $dataSet1['fare']['classOfService'] = $ticket->class;
        $dataSet1['fare']['totalFarePrice'] = $ticket->bought_price;

        return $dataSet1;
    }

    public function ticketDataProvider()
    {
        $this->setUp();

        $tests = [];

        for ( $i = 0; $i < 5; $i ++ ) {
            $train = factory( Train::class )->make();
            $ticket = factory( Ticket::class )->make();
            $dataSet1 = $this->createTicketDataset( $train, $ticket );
            $tests[ $i ] = [
                $train,
                $ticket,
                $dataSet1,
                $ticket->currency,
                $ticket->buyer_name,
                $ticket->eurostar_code,
                $ticket->buyer_email,
                $ticket->inbound
            ];
        }

        return $tests;
    }

    /**
     *
     * Test the function createTrainAndReturnTicket
     *
     * @dataProvider ticketDataProvider
     *
     */
    public function testCreateTrainAndReturnTicket( $train, $ticket, $data, $currency, $lastName, $referenceNumber, $buyerEmail, $outbound, $past = false )
    {
        $oldCount = Train::count();

        $foundTicket = \App\Facades\Eurostar::createTrainAndReturnTicket( $data, $currency, $lastName, $referenceNumber, $buyerEmail, $outbound, $past );

        $this->assertGreaterThan( $oldCount, Train::count() );

        $this->assertDatabaseHas( 'trains', [
            'number'         => $train->number,
            'departure_city' => $train->departure_city,
            'arrival_city'   => $train->arrival_city,
            'departure_date' => $train->departure_date,
            'arrival_date'   => $train->arrival_date,
            'departure_time' => $train->departure_time,
            'arrival_time'   => $train->arrival_time,
        ] );

        $ticketArray = $ticket->toArray();
        $ticketArray['bought_currency'] = $currency;
        $ticketArray['inbound'] = ! $outbound;
        unset( $ticketArray['train_id'] );
        unset( $ticketArray['user_id'] );
        unset( $ticketArray['user_notes'] );
        unset( $ticketArray['price'] );
        unset( $ticketArray['currency'] );

        foreach ( $ticketArray as $key => $value ) {
            $this->assertEquals( $value, $foundTicket->toArray()[ $key ] );
        }

    }

    /**
     *
     * Test the function createTrainAndReturnTicket and make sure no past ticket are found
     *
     */
    public function testCreateTrainAndReturnNoPastTicket()
    {

        $train = factory( Train::class )->make();
        $ticket = factory( Ticket::class )->make();

        $dataSet1 = $this->createTicketDataset( $train, $ticket );
        $dataSet1['info']['departureDate'] = '1996-08-01';
        $dataSet1['info']['arrivalDate'] = '1996-08-01';

        $foundTicket = \App\Facades\Eurostar::createTrainAndReturnTicket( $dataSet1, $ticket->currency, $ticket->buyer_name, $ticket->eurostar_code, $ticket->buyer_email, $ticket->inbound, false );

        $this->assertNull( $foundTicket );
    }


    /**
     *
     * Test that family name and code can retrieve one ticket
     * Only one ticket in this booking for a future day
     *
     */

    public function testRetrieveTicket()
    {
        // Set only one ticket
        $customTicketsList = $this->bookingInfo;

        // Create a train for tomorrow
        $train = factory( Train::class )->make();
        $tomorrow = new \DateTime( 'tomorrow' );
        $train->departure_date = $tomorrow->format(Eurostar::DATE_FORMAT_DB);
        $train->arrival_date = $tomorrow->format(Eurostar::DATE_FORMAT_DB);

        $ticket = factory( Ticket::class )->make();

        $ticketData1 = $this->createTicketDataset( $train, $ticket );

        $customTicketsList['booking']['passengers'][0]['outbound']['legs'] = [$ticketData1];

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $customTicketsList ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $ticket = $tickets[0];
        $this->assertEquals( 1, count( $tickets ) );
        $this->assertEquals( $this->bookingCode, $ticket->eurostar_code );

        $train = Train::where(
            [
                'number'         => $train->number,
                'departure_date' => $train->departure_date,
                'departure_time' => date( "H:i:s", strtotime( $train->departure_time ) ),
                'departure_city' => $train->departure_city,
                'arrival_date'   => $train->arrival_date,
                'arrival_time'   => date( "H:i:s", strtotime( $train->arrival_time ) ),
                'arrival_city'   => $train->arrival_city
            ]
        )->firstOrFail();

        // Make sure same train for ticket
        $this->assertEquals($train, $ticket->train);
    }


    /**
     *
     * Test that retrieved tickets have a proper 24-time format saved
     *
     */

    public function testRetrieveTicketAllDay()
    {
        // Set only one ticket
        $customTicketsList = $this->bookingInfo;

        // Create a train for tomorrow
        $train = factory( Train::class )->make();
        $tomorrow = new \DateTime( 'tomorrow' );
        $tomorrow->setTime( 14, 55 );
        $train->departure_date = $tomorrow->format(Eurostar::DATE_FORMAT_DB);
        $train->arrival_date = $tomorrow->format(Eurostar::DATE_FORMAT_DB);

        $ticket = factory( Ticket::class )->make();

        $ticketData1 = $this->createTicketDataset( $train, $ticket );

        $customTicketsList['booking']['passengers'][0]['outbound']['legs'] = [$ticketData1];

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $customTicketsList ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $ticket = $tickets[0];
        $this->assertEquals( 1, count( $tickets ) );
        $this->assertEquals( $this->bookingCode, $ticket->eurostar_code );

        $train = Train::where(
            [
                'number'         => $train->number,
                'departure_date' => $train->departure_date,
                'departure_time' => date( "H:i:s", strtotime( $train->departure_time ) ),
                'departure_city' => $train->departure_city,
                'arrival_date'   => $train->arrival_date,
                'arrival_time'   => date( "H:i:s", strtotime( $train->arrival_time ) ),
                'arrival_city'   => $train->arrival_city
            ]
        )->firstOrFail();

        // Make sure same train for ticket
        $this->assertEquals($train, $ticket->train);
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
        $customTicketsList = $this->bookingInfo;

        // Create a train for tomorrow
        $train1 = factory( Train::class )->make();
        $train2 = factory( Train::class )->make();
        $yesterday = new \DateTime( 'yesterday' );
        $tomorrow = new \DateTime( 'tomorrow' );
        $train1->departure_date = $yesterday->format(Eurostar::DATE_FORMAT_DB);
        $train1->arrival_date = $yesterday->format(Eurostar::DATE_FORMAT_DB);
        $train2->departure_date = $tomorrow->format(Eurostar::DATE_FORMAT_DB);
        $train2->arrival_date = $tomorrow->format(Eurostar::DATE_FORMAT_DB);

        $ticket = factory( Ticket::class )->make();

        $ticketData1 = $this->createTicketDataset( $train1, $ticket );
        $ticketData2 = $this->createTicketDataset( $train2, $ticket );

        $customTicketsList['booking']['passengers'][0]['outbound']['legs'] = [$ticketData1];
        $customTicketsList['booking']['passengers'][0]['inbound']['legs'] = [$ticketData2];
        $customTicketsList['booking']['isReturn'] =  true;

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $customTicketsList ) ),
        ] );
        $handler = HandlerStack::create( $mock );
        $client = new Client( [ 'handler' => $handler ] );

        $eurostarApi = new Eurostar( $client );
        $tickets = $eurostarApi->retrieveTicket( $this->familyName, $this->bookingCode );

        /* @var Ticket $ticket */
        $ticket = $tickets[0];
        $this->assertEquals( 1, count( $tickets ), 'Two tickets were retrieved instead of one' );
        $this->assertEquals( $this->bookingCode, $ticket->eurostar_code );

        $train = Train::where(
            [
                'number'         => $train2->number,
                'departure_date' => $train2->departure_date,
                'departure_time' => date( "H:i:s", strtotime( $train2->departure_time ) ),
                'departure_city' => $train2->departure_city,
                'arrival_date'   => $train2->arrival_date,
                'arrival_time'   => date( "H:i:s", strtotime( $train2->arrival_time ) ),
                'arrival_city'   => $train2->arrival_city
            ]
        )->firstOrFail();

        // Make sure same train for ticket
        $this->assertEquals($train, $ticket->train);

    }


    /**
     *
     * One ticket in booking, but is passed
     *
     */
    public function testRetrieveTicketNoTicket()
    {
        // Set only one ticket
        $customTicketsList = $this->bookingInfo;

        // Create a train for tomorrow
        $train = factory( Train::class )->make();
        $yesterday = new \DateTime( 'yesterday' );
        $train->departure_date = $yesterday->format(Eurostar::DATE_FORMAT_DB);
        $train->arrival_date = $yesterday->format(Eurostar::DATE_FORMAT_DB);

        $ticket = factory( Ticket::class )->make();

        $ticketData1 = $this->createTicketDataset( $train, $ticket );

        $customTicketsList['booking']['passengers'][0]['outbound']['legs'] = [$ticketData1];

        // Mock client
        $mock = new MockHandler( [
            new Response( 200, [], \GuzzleHttp\json_encode( $customTicketsList ) ),
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
