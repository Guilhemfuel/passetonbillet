<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{

    CONST CLAIM_LIMIT_PURCHASER = 24;
    CONST CLAIM_LIMIT_SELLER = 24;

    //Claim is won or lost for the Purchaser
    CONST CLAIM_STATUS_WON = 'WON';
    CONST CLAIM_STATUS_LOST = 'LOST';
    CONST CLAIM_STATUS_EQUALITY = 'EQUALITY';

    protected $fillable = [
        'ticket_id',
        'seller_id',
        'purchaser_id',
        'status',
        'claim_purchaser',
        'claim_seller',
    ];

    public static $relationships = [ 'seller', 'purchaser', 'ticket'];

    public function seller()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function purchaser()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function ticket()
    {
        return $this->belongsTo( 'App\Ticket' );
    }
}
