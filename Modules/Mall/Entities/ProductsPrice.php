<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductsPrice extends Model
{
    use SoftDeletes;
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