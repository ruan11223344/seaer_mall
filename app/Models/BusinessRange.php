<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRange extends Model
{
    protected $table = 'business_range';

    protected $fillable = [
        'name',
        'cn_name',
        'sort',
    ];

}
