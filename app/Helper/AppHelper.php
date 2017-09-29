<?php


namespace App\Helper;

class AppHelper
{
    public function dbDate($date){
        return date('Y-m-d', strtotime($date));
    }
}