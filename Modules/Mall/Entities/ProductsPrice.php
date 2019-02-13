<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductsPrice extends Model
{

    protected $table = 'products_price';

    protected $fillable = [
        'id',
        'price_type',
        'base_price',
        'ladder_price',
        'currency',
    ];

    protected $casts = [
        'base_price' => 'array',
        'ladder_price' => 'array',
    ];

}