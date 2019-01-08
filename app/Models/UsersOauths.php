<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersOauths extends Model
{
    protected $fillable = [
        'user_id', 'oauth_type', 'oauth_id','union_id','credential',
    ];
}
