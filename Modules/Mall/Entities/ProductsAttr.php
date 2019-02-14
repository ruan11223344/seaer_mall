<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsAttr extends Model
{
    use SoftDeletes;
    protected $table = 'products_attr';

    protected $fillable = [
        'id',
        'attr_specs',
    ];

    protected $casts = [
        'attr_specs' => 'array',
    ];

}