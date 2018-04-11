<?php


namespace App\Helper;

use App\Models\Statistic;

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

    public function stat($action,$data){
        if (\Auth::check()) {
            if (\Auth::user()->isAdmin()) {
                return null;
            }
            return Statistic::create(['user_id'=>\Auth::user()->id,'action'=>$action,'data'=>json_encode($data)]);
        } else {
            return Statistic::create(['data'=>json_encode($data),'action'=>$action]);
        }
    }

    /**
     * Returns an associative array with for each date in period the number of created items
     * By default, one month history
     *
     * @param $model
     * @param $period
     *
     * @return Array
     */
    public function dailyCreatedStat($model, $filterClosure = null, $field = 'created_at', $period = 'tomorrow -1 month'){

        $date = new \DateTime( 'tomorrow -1 month' );
        $dailyCount = $model::select( array(
            \DB::raw( "date(".$field.") as date" ),
            \DB::raw( "COUNT(*) as count" )
        ) )
                              ->where( $field, '>', $date )
                              ->groupBy( 'date' )
                              ->orderBy( 'date', 'DESC' );

        if ($filterClosure!=null){
            $dailyCount = $filterClosure($dailyCount);
        }


        return $dailyCount->pluck( 'count', 'date' );
    }

}