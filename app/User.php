<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,EntrustUserTrait,Messagable;
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
        return $this->hasMany('Modules\Mall\Entities\MailRecored','user_id','id');
    }

    public function captcha(){
        return $this->hasMany('Modules\Mall\Entities\Captcha','user_id','id');
    }

    public function usersExtends(){
        return $this->hasOne('Modules\Mall\Entities\UsersExtends','user_id','id');
    }

    public function company(){
        return $this->hasOne('Modules\Mall\Entities\Company','user_id','id');
    }

}

