<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    CONST STATUS_TRANSFER_DONE = 'DONE';
    CONST STATUS_TRANSFER_FAIL = 'FAIL';
    CONST STATUS_TRANSFER_PENDING = 'PENDING';
    CONST STATUS_REFUND_SELLER = 'REFUND_SELLER';
    CONST STATUS_REFUND_PURCHASER = 'REFUND_PURCHASER';
    CONST STATUS_REFUND_EACH = 'REFUND_EACH';

    CONST FEES = 20;

    protected $fillable = [
        'wallet_id',
        'seller_id',
        'purchaser_id',
        'ticket_id',
        'status',
        'transaction_mangopay',
        'status_transfer',
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
        return $this->belongsTo( 'App\Ticket', 'id');
    }
}
