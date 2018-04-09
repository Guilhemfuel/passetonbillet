<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statistic extends Model
{
    use SoftDeletes;

    protected $dates = [ 'deleted_at','created_at' ];

    protected $fillable = [
        'user_id',
        'action',
        'data'
    ];

    /**
     * RELATIONSHIPS
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }
}
