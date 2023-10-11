<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class Customer
 * @property string $email
 * @property string $phone
 * @property date $birthday
 * @property string $full_name
 * @property string $password
 * @property string $reset_password
 * @property string $address
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $commune_id
 * @property string $status
 * @property boolean $flag_delete
 */


class Customer extends Authenticatable
{
    use  HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'birthday',
        'full_name',
        'password',
        'address',
        'province_id',
        'district_id',
        'commune_id',
        'status',
        'flag_delete',
    ];

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
     * Get all of the orders for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

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
        return $this->belongsTo(District::class);
    }

     /**
     * Get the commune that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}
