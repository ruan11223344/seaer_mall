<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsProductsGroup extends Model
{
    use SoftDeletes;
    protected $table = 'products_products_group';

    protected $fillable = [
        'id',
        'product_id',
        'product_group_id',
    ];

}