<?php

namespace Modules\Mall\Entities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use SoftDeletes;
    protected $table = 'favorites';

    protected $fillable = [
        'id',
        'company_id',
        'type',
        'product_or_company_id',
    ];

    public function company()
    {
        return $this->belongsTo('Modules\Mall\Entities\Company','company_id','id');
    }
}