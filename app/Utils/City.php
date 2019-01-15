<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 10:04 AM
 */

namespace App\Utils;

use Khsing\World\Models\Country;

class City{
    public static function getProvincesList($country_code = 'ke'){
        $country = Country::getByCode($country_code);
        $provinces = $country->divisions();
        return $provinces;
    }

    public static function getCityList($province_id){
        $citys = \Khsing\World\Models\City::where('division_id',$province_id);
        return $citys;
    }


}