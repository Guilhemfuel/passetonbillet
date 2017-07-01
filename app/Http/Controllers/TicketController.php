<?php

namespace App\Http\Controllers;

use App\Exceptions\EurostarException;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function test(){

        $url = 'https://m.eurostar.com/api/v2/mob/fr-fr/booking/retrieve';

//        Collect Data
        $name = "nahum";
        $code = "QBVPJP";

//        Encore JSON to post
        $data = '{"travellers": [{"ln": "'.$name.'","pnr": "'.$code.'"}]}';

        $ch = curl_init($url);

        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        //Execute the request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));

        if (isset($result->{$code."-".$name})) {
            print_r( $result->{$code . "-" . $name}->{"LoadTravelOutput"} );
        } else {
            throw new EurostarException('Ticket not found!');
        }

    }

}
