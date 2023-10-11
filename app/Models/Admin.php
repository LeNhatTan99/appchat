<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;


/** 
 * class Admin 
 *  @property string   $email
 *  @property string   $user_name
 *  @property date   $birthday
 *  @property string   $first_name
 *  @property string   $last_name
 *  @property string   $password
 *  @property string   $reset_password
 *  @property string   $status
 *  @property tinyinteger   $flag_delete
 */

class Admin extends  Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guard = "admin";

    protected $fillable = [
        'email',
        'user_name',
        'birthday',
        'first_name',
        'last_name',
        'password',
        'reset_password',
        'status',
        'flag_delete',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
