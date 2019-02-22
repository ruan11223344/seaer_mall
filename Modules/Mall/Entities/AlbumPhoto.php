<?php

namespace Modules\Mall\Entities;
use Illuminate\Database\Eloquent\Model;

class AlbumPhoto extends Model
{
    protected $table = 'album_photo';

    protected $fillable = [
        'id',
        'album_id',
        'photo_name',
        'photo_url',
        'soft_delete',
    ];

    protected $casts = [
        'soft_delete' => 'boolean',
    ];

    protected $hidden = [
        'soft_delete',
    ];

    public function album_user(){
        return $this->belongsTo('Modules\Mall\Entities\AlbumUser','album_id','id');
    }
}
