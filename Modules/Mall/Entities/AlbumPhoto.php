<?php

namespace Modules\Mall\Entities;
use Illuminate\Database\Eloquent\Model;

class AlbumPhoto extends Model
{
    protected $table = 'album_photo';

    protected $fillable = [
        'id',
        'album_name',
        'album_description',
        'user_id',
        'soft_delete',
    ];

    protected $casts = [
        'soft_delete' => 'boolean',
    ];

    protected $hidden = [
        'soft_delete',
    ];
}
