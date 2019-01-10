<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class MailRecored extends Model
{
    protected $table = 'mail_recored';

    protected $fillable = [
        'id', 'user_id', 'to','status','template_name',
    ];

    public function user()
    {
        return $this->belongsTo('Modules\Mall\Entities\User','user_id','id');
    }

}
