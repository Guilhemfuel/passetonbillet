<?php


namespace App\Helper;

class AppHelper
{
    public function dbDate( $date )
    {
        if ( $date == null ) {
            return null;
        }

        return date( 'Y-m-d', strtotime( $date ) );
    }

    public function removeAccents(String $string){
        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
        return str_replace($search, $replace, $string);
    }

}