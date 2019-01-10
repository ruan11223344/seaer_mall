<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersExtends extends Model
{
    protected $table = 'user_extends';

    protected $fillable = [
        'user_id',
        'member_id',
        'af_id',
        'company_id',
        'account_type',
        'country_id',
        'region_id',
        'zip_code',
        'calling_code',
        'mobile',
        'sex',
        'contact_full_name',
        'chinese_name',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
