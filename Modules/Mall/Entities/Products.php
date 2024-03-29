<?php

namespace Modules\Mall\Entities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use SoftDeletes;
    protected $table = 'products';

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
        'company_id',
        'product_attr_id',
        'product_details'
    ];

    protected $casts = [
        'product_keywords' => 'array',
        'product_images' => 'array',
    ];

    public function products_categories(){
        return $this->hasOne('Modules\Mall\Entities\ProductsCategories','id','product_categories_id');
    }

    public function products_price(){
        return $this->hasOne('Modules\Mall\Entities\ProductsPrice','id','product_price_id');
    }

    public function products_attr(){
        return $this->hasOne('Modules\Mall\Entities\ProductsAttr','id','product_attr_id');
    }

    public function products_products_group(){
        return $this->hasOne('Modules\Mall\Entities\ProductsProductsGroup','product_id','id');
    }


}