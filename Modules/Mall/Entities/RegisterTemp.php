<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class RegisterTemp extends Model
{
    const STATUS_WAITING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAIL = 3;

    protected $table = 'register_temp';

    protected $fillable = [
        'email',
        'name',
        'account_type',
        'status',
        'register_uuid',
    ];

}
