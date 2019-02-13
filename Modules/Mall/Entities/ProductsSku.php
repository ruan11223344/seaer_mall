<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductsSku extends Model
{
    protected $table = 'products_sku';

    protected $fillable = [
        'id',
        'product_id',
        'sku_attr_id',
    ];
}