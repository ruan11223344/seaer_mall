<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';

    protected $fillable = [
        'id',
        'ad_name',
        'width',
        'height',
        'jump_url',
        'image_path',
        'enabled',
        'is_slide',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'is_slide' => 'boolean'
    ];
}
