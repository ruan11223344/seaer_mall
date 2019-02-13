<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductsGroup extends Model
{

    protected $table = 'products_group';

    protected $fillable = [
        'id',
        'user_id',
        'group_name',
        'parent_id',
        'show_home_page',
    ];

    protected $casts = [
        'show_home_page' => 'boolean',
    ];

}