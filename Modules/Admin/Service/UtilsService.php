<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/15
 * Time: 11:07 AM
 */

namespace Modules\Admin\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Modules\Admin\Entities\AdminLog;
use Modules\Admin\Entities\UserLog;

class UtilsService
{
    const ADMIN_LOG_TYPE = [];
    const ADMIN_LOG_ACTION = [];

    const USER_LOG_TYPE = [];
    const USER_LOG_ACTION = [];

    public static function Captcha(){
        return app('captcha')->create('default', true);
    }

    public static function WriteLog($table,$type,$action,$user_or_admin_id,$type_for_id){
        try{
            $ip  = Request::ip();
            if($table == 'admin'){
                AdminLog::create(
                  [
                      'type'=>$type,
                      'action'=>$action,
                      'ip'=>$ip,
                      'admin_id'=>$user_or_admin_id,
                      'type_for_id'=>$type_for_id,
                  ]
                );
            }elseif ($table == 'user'){
                UserLog::create(
                    [
                        'type'=>$type,
                        'action'=>$action,
                        'ip'=>$ip,
                        'user_id'=>$user_or_admin_id,
                        'type_for_id'=>$type_for_id,
                    ]
                );
            }
        }catch (\Exception $e){
            dd($e->getMessage());
            Log::error('Log Table is Error! Message:'.$e->getMessage());
        }
    }
}