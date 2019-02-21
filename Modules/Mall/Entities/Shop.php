<?php

namespace Modules\Mall\Entities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shop';
    protected $fillable = [
        'id',
        'company_id',
        'recommend_product',
        'banner_url',
        'slides_url_list',
    ];

    protected $casts = [
        'recommend_product' => 'array',
        'slides_url_list' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo('Modules\Mall\Entities\Company','company_id','id');
    }
}