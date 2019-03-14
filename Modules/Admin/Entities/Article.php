<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;
    protected $table = 'article';

    protected $fillable = [
        'id',
        'admin_id',
        'author',
        'title',
        'content',
        'type',
    ];
}
