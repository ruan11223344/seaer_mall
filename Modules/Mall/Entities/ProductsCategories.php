<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ProductsCategories extends Model
{
    use NodeTrait;
    protected $table = 'products_categories';

    protected $fillable = [
        'id','name','_lft','_rgt','parent_id'
    ];

}