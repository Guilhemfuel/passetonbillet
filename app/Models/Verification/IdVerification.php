 <?php

namespace App\Models\Verification;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdVerification extends Model
{
    use SoftDeletes;

    public $table = 'id_verifications';

    public $fillable = [
        'user_id',
        'scan',
        'accepted',
        'comment'
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
        'comment'  => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'scan'    => 'required',
    ];

    /**
     * Static
     */

    public static function awaitingCount(){
        return static::where('accepted',null)->count();
    }

    public static function userIdFileName(User $user, $fileType){
        if ($fileType!='pdf') $fileType = 'jpg';
        return \Vinkla\Hashids\Facades\Hashids::connection('file')->encode($user->id).md5($user->full_name).'.'.$fileType;
    }

    /**
     * Mutators
     */


    public function getIsPdfAttribute(){
        return substr($this->scan,-3) == 'pdf';
    }

    public function getScanAttribute($value){
        return \Storage::disk('s3')->temporaryUrl(ltrim($value, '/'),now()->addMinutes(5));
    }


    /**
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }
}
