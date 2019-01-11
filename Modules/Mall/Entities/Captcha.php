<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    protected $table = 'captcha';

    protected $fillable = [
        'id','user_id','type','captcha','status','timeout_second','verify_from'
    ];

    public function user()
    {
        return $this->belongsTo('Modules\Mall\Entities\User','user_id','id');
    }
}