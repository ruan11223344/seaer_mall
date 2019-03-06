<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductAudit extends Model
{
    protected $table = 'product_audit';

    protected $fillable = [
        'admin_id',
        'product_id',
        'message',
        'status',
    ];
}
