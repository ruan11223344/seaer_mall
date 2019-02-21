<?php

namespace Modules\Mall\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'user_id',
        'company_name', //公司名称
        'company_country_id', //公司国家id
        'company_province_id', //公司省份id
        'company_city_id', //公司城市id
        'company_detailed_address', //公司纤详细地址
        'company_owner', //公司负责人
        'company_name_in_china', //公司中文名
        'company_business_license', //公司营业执照号
        'company_business_license_pic_url', //公司营业执照图片地址
        'company_established_time', //公司创建时间
        'company_website', //公司网站
        'company_number_of_employees', //员工人数
        'company_profile', //公司简介
        'company_business_type_id', //业务类型
        'company_business_range_id', //业务范围
        'company_mobile_phone', //联系手机
        'company_department', //公司部门
        'company_position',  //公司职位
        'company_sales_platform', //销售平台
        'company_main_products',  //主营产品
        'company_logo_url', //公司logo url
    ];

    public function user()
    {
        return $this->belongsTo('Modules\Mall\Entities\User','user_id','id');
    }

    public function favorites(){
        return $this->hasMany('Modules\Mall\Entities\Favorites','company_id','id');
    }

    public function shop(){
        return $this->hasOne('Modules\Mall\Entities\Shop','company_id','id');
    }
}
