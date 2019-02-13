<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductsAttr extends Model
{

    protected $table = 'products_attr';

    protected $fillable = [
        'id',
        'attr_specs',
    ];

    protected $casts = [
        'attr_specs' => 'array',
    ];

}