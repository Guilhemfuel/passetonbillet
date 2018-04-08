<?php

use Illuminate\Database\Seeder;
use App\Station;

class StationsTableSeeder extends Seeder
{
    /**
     * Add the eurostar stations to the database.
     *
     * @return void
     */
    public function run()
    {
        // London
//        $station = new Station();
//        $station->eurostar_id = 7015400;
//        $station->name_fr = "Londres St Pancras Int";
//        $station->name_en = "London St Pancras Int";
//        $station->short_name = "GBLON";
//        $station->country = "gb";
//        $station->timezone_txt = "Europe/London";
//        $station->timezone = "+01:00";
//        $station->save();
//
//        // Ebbsfleet
//        $station = new Station();
//        $station->eurostar_id = 7015440;
//        $station->name_fr = "Ebbsfleet";
//        $station->name_en = "Ebbsfleet";
//        $station->short_name = "GBEBF";
//        $station->country = "gb";
//        $station->timezone_txt = "Europe/London";
//        $station->timezone = "+01:00";
//        $station->save();
//
//        // Ashford
//        $station = new Station();
//        $station->eurostar_id = 7054660;
//        $station->name_fr = "Ashford";
//        $station->name_en = "Ashford";
//        $station->short_name = "GBASD";
//        $station->country = "gb";
//        $station->timezone_txt = "Europe/London";
//        $station->timezone = "+01:00";
//        $station->save();
//
//        // Disney
//        $station = new Station();
//        $station->eurostar_id = 8711184;
//        $station->name_fr = "Disneyland Resort (Marne-la-Vallée/Chessy)";
//        $station->name_en = "Disneyland Resort (Marne-la-Vallée/Chessy), France";
//        $station->short_name = "FRMVL";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Lille Europe
//        $station = new Station();
//        $station->eurostar_id = 8722326;
//        $station->name_fr = "Lille Europe";
//        $station->name_en = "Lille Europe";
//        $station->short_name = "FRLIL";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Paris
//        $station = new Station();
//        $station->eurostar_id = 8727100;
//        $station->name_fr = "Paris Gare Du Nord";
//        $station->name_en = "Paris Gare Du Nord";
//        $station->short_name = "FRPAR";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Calais
//        $station = new Station();
//        $station->eurostar_id = 8728107;
//        $station->name_fr = "Calais Frethun";
//        $station->name_en = "Calais Frethun";
//        $station->short_name = "FRCQF";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Avignon
//        $station = new Station();
//        $station->eurostar_id = 8731896;
//        $station->name_fr = "Avignon TGV";
//        $station->name_en = "Avignon TGV";
//        $station->short_name = "FRAVN";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Lyon
//        $station = new Station();
//        $station->eurostar_id = 8772319;
//        $station->name_fr = "Lyon Part-Dieu";
//        $station->name_en = "Lyon Part-Dieu";
//        $station->short_name = "FRLYS";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Moutiers
//        $station = new Station();
//        $station->eurostar_id = 8774172;
//        $station->name_fr = "Moutiers Salins Brides Les Bains";
//        $station->name_en = "Moutiers Salins Brides Les Bains";
//        $station->short_name = "FRQMU";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Bourg St Maurice
//        $station = new Station();
//        $station->eurostar_id = 8774179;
//        $station->name_fr = "Bourg St Maurice";
//        $station->name_en = "Bourg St Maurice";
//        $station->short_name = "FRQBM";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Marseille
//        $station = new Station();
//        $station->eurostar_id = 8775100;
//        $station->name_fr = "Marseille Saint Charles";
//        $station->name_en = "Marseille Saint Charles";
//        $station->short_name = "FRMRS";
//        $station->country = "fr";
//        $station->timezone_txt = "Europe/Paris";
//        $station->timezone = "+02:00";
//        $station->save();
//
//        // Bruxelles
//        $station = new Station();
//        $station->eurostar_id = 8814001;
//        $station->name_fr = "Bruxelles-Midi";
//        $station->name_en = "Brussels Midi";
//        $station->short_name = "BEBRU";
//        $station->country = "be";
//        $station->timezone_txt = "Europe/Brussels";
//        $station->timezone = "+02:00";
//        $station->save();

        // Amsterdam
        $station = new Station();
        $station->eurostar_id = 8400058;
        $station->name_fr = "Amsterdam";
        $station->name_en = "Amsterdam";
        $station->short_name = "NLAMS";
        $station->country = "nl";
        $station->timezone_txt = "Europe/Amsterdam";
        $station->timezone = "+02:00";
        $station->save();


    }
}
