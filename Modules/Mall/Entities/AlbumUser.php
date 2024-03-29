<?php

namespace Modules\Mall\Entities;
use Illuminate\Database\Eloquent\Model;

class AlbumUser extends Model
{
    protected $table = 'album_user';

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

    public function album_photo(){
        return $this->hasMany('Modules\Mall\Entities\AlbumPhoto','album_id','id');
    }

}
