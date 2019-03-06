<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table = 'admin_log';

    protected $fillable = [
        'id',
        'type',
        'action',
        'ip',
        'admin_id',
        'type_for_id',
    ];
}
