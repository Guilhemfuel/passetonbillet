<?php

/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/02/2017
 * Time: 00:00
 */

namespace App\EurostarAPI;

class Eurostar implements TrainInterface
{

    private $baseURL = "https://m.eurostar.com/api/mob/fr-fr/booking/proposals/";

    // For translation purposes
    private $cities_translation = [ "Londres" => "London", "Bruxelles" => "Brusells"];
    // Eurostar's city codes
    private $cities = ["London"=>7015400, "Paris"=>8727100, "Lille"=>8722326, "Brusells" => 8814001];

    //Simple helper to create date in a proper format
    public static function create_date($day,$month,$year){
        $date = date_create($year."-".$month."-".$day);
        return date_format($date,"Y-m-d");
    }

    //Retrieve all single way eurostar for a date, a city and a departure date
    public function singles($departure_city,$arrival_city,$departure_date){

        // Translate city names if needed
        $departure_city = $this->translate($departure_city);
        $arrival_city = $this->translate($arrival_city);

        // Check that cities exist
        $this->checkCities($departure_city,$arrival_city);

        // Retrieve Eurostar city codes
        $departure_city_code = $this->cities[$departure_city];
        $arrival_city_code = $this->cities[$arrival_city];

        //Construct URL
        $get_url = $this->baseURL."single/outbound/".$departure_city_code."/".$arrival_city_code."/1/0/0/0/".$departure_date;

        //Init Curl
        $curl = curl_init($get_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //Execute request
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            trigger_error('Error occured during curl execution Additional info: ' . var_export($info), E_USER_ERROR);
        }
        curl_close($curl);

        //Deal with response
        $decoded = json_decode($curl_response);
        if (isset($decoded->errors[0]->message)) {
            trigger_error('Error occured: ' . $decoded->errors[0]->message, E_USER_ERROR);
        }


        //TODO: Create train model+db with train number, time day, origin and destination (instanciate object after that)

        //TODO: Setup a function updateMonth() with cron saving/updating the whole month of train


        return $decoded;

    }

    //If query is in French, translate to english
    private function translate($city){
        if(array_key_exists($city, $this->cities_translation)){
            return $this->cities_translation[$city];
        }
        return $city;
    }

    private function checkCities($departure_city,$arrival_city){
        if (array_key_exists($departure_city, $this->cities)){
            if(array_key_exists($arrival_city, $this->cities)){
                return true;
            }
            trigger_error("Eurostar Error: Cannot find the city: ".$arrival_city, E_USER_ERROR);

        }
        trigger_error("Eurostar Error: Cannot find the city: ".$departure_city, E_USER_ERROR);
    }


}