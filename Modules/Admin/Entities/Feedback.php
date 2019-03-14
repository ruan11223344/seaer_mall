<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'id',
        'admin_id',
        'user_id',
        'user_message',
        'admin_message',
        'is_process',
        'is_spam',
        'contact_way',
    ];

    protected $casts = [
        'is_process' => 'boolean',
        'is_spam' => 'boolean'
    ];
}
