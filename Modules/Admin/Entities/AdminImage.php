<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class AdminImage extends Model
{
    protected $table = 'admin_image';

    protected $fillable = [
        'id',
        'admin_id',
        'image_path'
    ];

}
