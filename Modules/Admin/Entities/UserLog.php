<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_log';

    protected $fillable = [
        'id',
        'type',
        'action',
        'ip',
        'user_id',
        'type_for_id',
    ];

}
