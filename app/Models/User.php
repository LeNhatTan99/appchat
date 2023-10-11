<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

/** 
 * class User 
 *  @property string   $email
 *  @property string   $user_name
 *  @property date   $birthday
 *  @property string   $first_name
 *  @property string   $last_name
 *  @property string   $avatar
 *  @property string   $password
 *  @property string   $reset_password
 *  @property string   $status
 *  @property tinyInteger   $flag_delete
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'full_name',
        'birthday',
        'address',
        'province_id',
        'district_id',
        'commune_id',
        'avatar',
        'password',
        'reset_password',
        'status',
        'flag_delete',
    ];

    const  ACTIVE = 1;
    const  NOT_DELETE = 0;
    const  DELETED = 1;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the province that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    /**
     * Get the district that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

     /**
     * Get the commune that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

       /**
     * User has many message
     *
     * @return \Illuminate\Database\Eloquent\Relations\Hasmany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'user_conversation');
    }
}
