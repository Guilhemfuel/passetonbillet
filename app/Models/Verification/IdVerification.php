<?php

namespace App\Models\Verification;

use App\Rules\Country;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class IdVerification extends Model
{
    use SoftDeletes;

    const DOCUMENT_TYPES = [
        'driving_license',
        'id',
        'passport'
    ];

    public $table = 'id_verifications';

    public $fillable = [
        'user_id',
        'scan',
        'accepted',
        'comment',
        'country',
        'type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'  => 'integer',
        'scan'     => 'string',
        'accepted' => 'boolean',
        'comment'  => 'string',
        'country'  => 'string',
        'type'     => 'string',
    ];

    /**
     * Validation rules
     */
    public static function rules( $merge = [] )
    {
        return array_merge( [
            'user_id' => 'exists:users,id',
            'scan'    => 'required|max:10240',
        ], $merge );
    }

    /**
     * Static
     */

    public static function awaitingCount()
    {
        return static::where( 'accepted', null )->count();
    }

    public static function userIdFileName( User $user, $fileType )
    {
        if ( $fileType != 'pdf' ) {
            $fileType = 'jpg';
        }

        return \Vinkla\Hashids\Facades\Hashids::connection( 'file' )->encode( $user->id ) . md5( $user->full_name ) . '.' . $fileType;
    }

    /**
     * Mutators
     */


    public function getIsPdfAttribute()
    {
        return substr( $this->attributes['scan'], - 3 ) == 'pdf';
    }

    public function getScanAttribute( $value )
    {
        return \Storage::disk( 's3' )->temporaryUrl( ltrim( $value, '/' ), now()->addMinutes( 5 ) );
    }

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }
}
