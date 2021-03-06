<?php


namespace App\Helper;

use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Resources\MissingValue;

class AppHelper
{
    public function dbDate( $date )
    {
        if ( $date == null ) {
            return null;
        }

        return date( 'Y-m-d', strtotime( $date ) );
    }

    public function removeAccents( $string )
    {
        if ( $string == null ) {
            return null;
        }

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
                'data'    => json_encode( $data ),
                'ip'      => request()->ip()
            ] );
        } else {
            if ( $user ) {
                return Statistic::create( [
                    'user_id' => $user->id,
                    'action'  => $action,
                    'data'    => json_encode( $data ),
                    'ip'      => request()->ip()
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
        $stats = Statistic::where( 'action', Statistic::PAGE_STAT_ACTION )
                          ->where( 'created_at', '>', Carbon::today() )
                          ->get();

        $stat = null;
        foreach ( $stats as $candidateStat ) {
            $data = json_decode( $candidateStat->data );
            if ( $data->page == $page && $data->source == $source ) {
                $stat = $candidateStat;
            }
        }

        if ( $stat ) {
            $data = json_decode( $stat->data );
            $data->count ++;
            $stat->data = json_encode( $data );
            $stat->save();

            return $stat;
        } else {
            return Statistic::create( [
                'action' => Statistic::PAGE_STAT_ACTION,
                'data'   => json_encode( [
                    'page'   => $page,
                    'source' => $source,
                    'count'  => 1
                ] )
            ] );
        }
    }

    /**
     * Given a country return phone code
     *
     * @param $country
     */
    public function countryToPhoneCode( $countryCode )
    {
        $countryCode = strtolower($countryCode);

        $path = resource_path() . "/assets/data/phones.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $json = json_decode(file_get_contents($path), true)['phones'];

        $dict = [];
        foreach ($json as $country) {
            $dict[strtolower($country['code'])] = $country;
        }

        if (!array_key_exists($countryCode,$dict)) {
            throw new \Exception('Country code '.$countryCode.' not found.');
        }

        return $dict[$countryCode]['callingCode'];

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

        $date = new \DateTime( $period );
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

        // Sort by date
        ksort( $data );

        return $data ;

    }

    /**
     * Add campaign details to URL
     *
     * @param $url
     * @param $campaignSource
     * @param $campaignMedium
     * @param $campaignName
     * @param $campaignTerm
     * @param $campaignContent
     */
    public function googleCampaign( $url, $campaignSource, $campaignMedium, $campaignName, $campaignTerm = null, $campaignContent = null)
    {
        $parsedUrl = parse_url($url);

        // Add parameters
        if ($parsedUrl['query']) {
            // Url already has parameters
            $url = $url . '&utm_source=' . urlencode( $campaignSource ) .
                   '&utm_medium=' . urlencode( $campaignMedium ) . '&utm_campaign=' . urlencode( $campaignName );
        } else {
            // Already does not have parameters yet
            $url = $url . '?utm_source=' . urlencode( $campaignSource ) .
                   '&utm_medium=' . urlencode( $campaignMedium ) . '&utm_campaign=' . urlencode( $campaignName );
        }

        if ($campaignTerm) {
            $url .= '&utm_term=' . urlencode($campaignTerm);
        }
        if ($campaignContent) {
            $url .= '&utm_content=' . urlencode($campaignTerm);
        }

        return $url;
    }

}