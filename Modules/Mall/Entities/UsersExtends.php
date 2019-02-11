<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class UsersExtends extends Model
{
    protected $table = 'users_extends';

    const ACCOUNT_TYPE_COMPANY_CHINA = 0; //中国卖家
    const ACCOUNT_TYPE_COMPANY_KENYA = 1; //肯尼亚卖家
    const ACCOUNT_TYPE_BUYER_KENYA = 2;  //肯尼亚买家

    protected $fillable = [
        'user_id',
        'af_id',
        'company_id',
        'account_type',
        'country_id',
        'region_id',
        'zip_code',
        'mobile',
        'sex',
        'contact_full_name',
        'chinese_name',
        'id_card_name',
        'id_card_num',
        'id_card_positive_pic_url',
        'id_card_negative_pic_url',
        'email_notification',
    ];

    protected $casts = [
        'email_notification' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('Modules\Mall\Entities\User','user_id','id');
    }
}
