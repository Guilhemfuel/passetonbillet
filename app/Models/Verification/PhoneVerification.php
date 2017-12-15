<?php

namespace App\Models\Verification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneVerification extends Model
{
    use SoftDeletes;

    public $table = 'phone_verifications';

    public $fillable = [
        'user_id',
        'phone_country',
        'phone',
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'  => 'integer',
        'phone_country' => 'string',
        'phone'      => 'string',
        'code'   => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id'         => 'required|exists:users,id',
        'phone_country'   => 'exists:tickets,id',
        'mark' => 'required',
    ];

    /**
     * Mutators
     */

    /**
     * Return the phone number to be used (with country indicator)
     *
     * @return null
     */
    public function getPhoneNumberAttribute()
    {
        switch ($this->phone_country){
            case 'FR':
                return '33'.substr($this->phone, 1);
                break;
            case 'GB':
                return '44'.substr($this->phone, 1);
                break;
            case 'BE':
                return '32'.substr($this->phone, 1);
                break;
        }

        return null;
    }

    public function getMessageAttribute() {
        return $this->code.__('sms.number_verification');
    }

    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }
    
}
