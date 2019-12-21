<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    CONST STATUS_TRANSFER_SUCCESS = 'SUCCEEDED';
    CONST STATUS_TRANSFER_FAIL = 'FAILED';
    CONST STATUS_TRANSFER_CREATED = 'CREATED';
    CONST STATUS_NO_BANK_ACCOUNT = 'NO_BANK_ACCOUNT';
    CONST STATUS_NO_KYC = 'NO_KYC';

    CONST FEES_TICKET_ON_SALE = 10; //When someone put a ticket on sale
    CONST FEES_CLAIM_PURCHASER = 5;
    CONST FEES_SELLER = 5;
    //When equality, we split price / 2, so 100€ become 50€
    //Then we apply fees to 50€ for each
    CONST FEES_EQUALITY_SELLER = 10;
    CONST FEES_EQUALITY_PURCHASER = 0;

    protected $fillable = [
        'wallet_id',
        'seller_id',
        'purchaser_id',
        'ticket_id',
        'status',
        'transaction_mangopay',
        'status_refund',
        'refund_id',
        'status_payout',
        'payout_id',
    ];

    public static $relationships = [ 'user', 'ticket'];

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
        return $this->belongsTo( 'App\Ticket');
    }
}
