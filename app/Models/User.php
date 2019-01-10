<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function emailRecored()
    {
        return $this->hasMany('App\Models\MailRecored','user_id','id');
    }

    public function captcha(){
        return $this->hasMany('App\Models\Captcha','user_id','id');
    }

    public function usersExtends(){
        return $this->hasOne('App\Models\UsersExtends','user_id','id');
    }

}

