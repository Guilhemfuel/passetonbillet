<?php

namespace App;
use App\Traits\ScamFiltered;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

abstract class AbstractTicket extends BaseModel
{
    use SearchableTrait, SoftDeletes, ScamFiltered;
    protected $dates = [ 'deleted_at', 'marked_as_fraud_at' ];
    protected $with = ['user'];

    CONST MAX_PRICE = 1000;

    // These fillable are required for child classes
    protected $fillable = [
        // User info
        'user_id',
        'user_notes',
        'price',
        'currency',
        // Id of user who bought ticket
        'sold_to_id',
        'bought_price',
        'bought_currency',
        'marked_as_fraud_at'
    ];
    public static $rules = [
        'user_id'         => 'required|exists:users,id',
        'sold_to_id'      => 'exists:users,id',
        'price'           => 'required|numeric',
        'bought_price'    => 'required|numeric',
        'currency'        => 'required',
        'bought_currency' => 'required',
    ];
    /**
     * Helper
     */
    protected function getSymbolCurrency( $currency )
    {
        switch ( $currency ) {
            case "EUR":
            case "EFT":
                return '€';
                break;
            case "USD":
                return '$';
                break;
            case "GBP":
                return '£';
                break;
        }
        return '';
    }
    /**
     * MUTATORS
     */
    public function getPassedAttribute()
    {
        $now = new Carbon();
        return $this->train->carbon_departure_date->lt( $now );
    }

    public function getFullPriceAttribute()
    {
        if ( $this->currency == 'EUR' ) {
            return $this->price . '€';
        } else {
            return $this->currency_symbol . $this->price;
        }
    }

    public function getCurrencySymbolAttribute()
    {
        return $this->getSymbolCurrency( $this->currency );
    }

    public function getBoughtCurrencySymbolAttribute()
    {
        return $this->getSymbolCurrency( $this->bought_currency );
    }

    public function getStatusAttribute()
    {
        if ( $this->scam ) {
            return 'scam';
        } else if ( $this->sold_to_id ) {
            return 'sold';
        } else {
            if ( $this->passed ) {
                return 'passed';
            } else {
                return 'selling';
            }
        }
    }

    public function getScamAttribute()
    {
        return $this->marked_as_fraud_at != null;
    }

    public function getHashIdAttribute()
    {
        return \Hashids::encode( $this->id );
    }

    public function setSoldToIdAttribute( $value )
    {
        $this->attributes['sold_to_id'] = $value;
    }

    public function getSoldAttribute() {
        if($this->sold_to_id) {
            return true;
        }
        return false;
    }

    /**
     * RELATIONSHIPS
     */
    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }
    /**
     * Static
     */
    public static function getMostRecentTickets( $limit ) {
        return self::latest('created_at')->limit($limit)->get();
    }

    public function maxPrice() {
        return (self::MAX_PRICE / 100) * $this->bought_price;
    }

    public function hasPdf() {
        return $this->pdf ? true : false;
    }
}
