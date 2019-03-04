<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
class Admin extends Model
{
    use EntrustUserTrait,HasApiTokens,Notifiable,Authenticatable;
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

    public function findForPassport($username)
    {
        return $this->orWhere('email', $username)->orWhere('name', $username)->first();
    }
}
