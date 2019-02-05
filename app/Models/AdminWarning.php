<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminWarning
 * @package App\Models
 *
 * Used to store all actions that must be reviewed by admin.
 */
class AdminWarning extends Model
{
    const ACTION_PDF_DOWNLOAD_FAILED = 'pdf_download_failed';
    const TRY_TO_RESALE_TICKET = 'try_to_resale_ticket';
    const SIMILAR_ID_ACCEPTED = 'similar_id_accepted';
    const STRANGELY_LOW_TICKET_PRICE = 'strangely_low_ticket_price';
    const MANY_TICKETS_NEW_USER = 'many_tickets_new_user';

    public $table = 'admin_warnings';

    protected $dates = [ 'done_at', 'updated_at', 'created_at' ];

    protected $fillable = [
        'action',
        'data',
        'link',
    ];

    protected $casts = [
        'done_at'    => 'time',
        'data'       => 'array',
        'done_by_id' => 'integer',
        'link'       => 'string',
        'action'     => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'done_by_id' => 'required|exists:users,id',
        'data'       => 'required|json',
        'link'       => 'required|string',
        'action'     => 'required|string',
    ];

    public static function awaitingCount()
    {
        return static::where( 'done_at', null )->count();
    }

    /**
     * Relationships
     */
    public function doneBy()
    {
        return $this->belongsTo( 'App\User' );
    }
}
