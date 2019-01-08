<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersExtends extends Model
{
    protected $fillable = [
        'user_id', 'country_id', 'zip_code','phone','mobile',
    ];
}
