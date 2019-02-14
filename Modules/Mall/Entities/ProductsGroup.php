<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsGroup extends Model
{
    use SoftDeletes;

    protected $table = 'products_group';

    protected $fillable = [
        'id',
        'user_id',
        'group_name',
        'parent_id',
        'show_home_page',
        'sort'
    ];

    protected $casts = [
        'show_home_page' => 'boolean',
    ];

}