<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    CONST STATUS_TRANSFER_DONE = 'DONE';
    CONST STATUS_TRANSFER_FAIL = 'FAILED';
    CONST STATUS_TRANSFER_CREATED = 'CREATED';
    CONST STATUS_NO_BANK_ACCOUNT = 'NO_BANK_ACCOUNT';
    CONST STATUS_NO_KYC = 'NO_KYC';

    CONST FEES = 20;

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
