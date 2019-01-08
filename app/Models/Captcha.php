<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    protected $table = 'captcha';

    protected $fillable = [
        'id','user_id','type','captcha','status','timeout_second','verifiy_from'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}