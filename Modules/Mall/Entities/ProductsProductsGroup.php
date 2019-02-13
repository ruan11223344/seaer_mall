<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductsProductsGroup extends Model
{

    protected $table = 'products_products_group';

    protected $fillable = [
        'id',
        'product_id',
        'product_group_id',
    ];

}