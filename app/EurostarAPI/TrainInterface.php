<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/02/2017
 * Time: 23:58
 */
namespace App\EurostarAPI;

interface TrainInterface
{

    public function singles($departure_city,$arrival_city,$departure_date);

}