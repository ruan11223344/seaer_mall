<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'company_name', //公司名称
        'company_country_id', //公司国家id
        'company_region_id', //公司地区id
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
        'company_calling_code', //国家号码
        'company_mobile_phone', //联系手机
        'company_department', //公司部门
        'company_position',  //公司职位
        'company_sales_platform', //销售平台
        'company_main_products',  //主营产品
        'company_logo_url', //公司logo url
        'company_id_card_name', //身份证姓名
        'company_id_card', //身份证号
        'company_id_positive_pic_url', //身份证图片url
        'company_id_negative_pic_url', //身份证图片url
    ];
}
