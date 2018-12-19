<?php


namespace App\Helper;

use App\Models\Statistic;
use Carbon\Carbon;

class AppHelper
{
    public function dbDate( $date )
    {
        if ( $date == null ) {
            return null;
        }

        return date( 'Y-m-d', strtotime( $date ) );
    }

    public function removeAccents( String $string )
    {
        $search = explode( ",", "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u" );
        $replace = explode( ",", "c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u" );

        return str_replace( $search, $replace, $string );
    }

    /**
     * Create a statistic
     *
     * @param      $action
     * @param      $data
     * @param null $user
     *
     * @return null
     */
    public function stat( $action, $data, $user = null )
    {
        if ( \Auth::check() ) {
            if ( \Auth::user()->isAdmin() ) {
                return null;
            }

            return Statistic::create( [
                'user_id' => \Auth::user()->id,
                'action'  => $action,
                'data'    => json_encode( $data )
            ] );
        } else {
            if ( $user ) {
                return Statistic::create( [
                    'user_id' => $user->id,
                    'action'  => $action,
                    'data'    => json_encode( $data )
                ] );
            } else {
                return Statistic::create( [ 'data' => json_encode( $data ), 'action' => $action ] );
            }
        }
    }

    /**
     * Create a count statistic of increment daily one if already exists.
     */
    public function pageStat( $page, $source = null )
    {
        $stat = Statistic::where( 'action', Statistic::PAGE_STAT_ACTION )
                         ->where( 'created_at', '>',Carbon::today() )
                         ->where( 'data->source', $source )
                         ->where( 'data->page', $page )
                         ->first();

        if ( $stat ) {
            $data = $stat->data;
            $data['count']++;
            $stat->data = $data;
            $stat->save();

            return $stat;
        } else {
            return Statistic::create( [
                'action' => Statistic::PAGE_STAT_ACTION,
                'data'   => [
                    'page' => $page,
                    'source' => $source,
                    'count' => 1
                ]
            ] );
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
    public function dailyCreatedStat( $model, $filterClosure = null, $field = 'created_at', $period = 'tomorrow -1 month' )
    {

        $date = new \DateTime( 'tomorrow -1 month' );
        $dailyCount = $model::select( array(
            \DB::raw( "date(" . $field . ") as date" ),
            \DB::raw( "COUNT(*) as count" )
        ) )
                            ->where( $field, '>', $date )
                            ->groupBy( 'date' )
                            ->orderBy( 'date', 'DESC' );

        if ( $filterClosure != null ) {
            $dailyCount = $filterClosure( $dailyCount );
        }

        $today = Carbon::now();
        $aMonthAgo = Carbon::now()->subMonth();

        $data = $dailyCount->pluck( 'count', 'date' )->toArray();

        // Add 0 to missing dates
        while ( $today->format( 'Y-m-d' ) != $aMonthAgo->format( 'Y-m-d' ) ) {
            if ( ! isset( $data[ $today->format( 'Y-m-d' ) ] ) ) {
                $data[ $today->format( 'Y-m-d' ) ] = 0;
            }
            $today->subDay();
        }

        // Sort by date and reverse
        ksort( $data );

        return array_reverse( $data );

    }

}