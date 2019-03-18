<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class IndexProductRecommend extends Model
{
    protected $table = 'index_product_recommend';

    protected $fillable = [
        'id',
        'product_id',

    ];
}
