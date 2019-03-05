<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Admin\Service;

class UtilsService
{
    public static function Captcha(){
        return app('captcha')->create('default', true);
    }


}