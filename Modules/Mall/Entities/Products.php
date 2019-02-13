<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{

    protected $table = 'products_categories';

    protected $fillable = [
        'id',
        'product_origin_id',
        'product_categories_id',
        'product_name',
        'product_sku_no',
        'product_keywords',
        'product_images',
        'product_status',
        'product_audit_status',
        'product_publishing_time',
        'product_price_id',
    ];

    protected $casts = [
        'product_keywords' => 'array',
        'product_images' => 'array',
    ];

}