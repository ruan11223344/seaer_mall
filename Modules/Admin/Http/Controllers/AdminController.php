<?php

namespace Modules\Admin\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AdminLog;
use Modules\Admin\Entities\UserLog;
use App\Utils\EchoJson;


class AdminController extends Controller
{
    use EchoJson;
    public function index()
    {
        return view('admin::index');
    }

    public function getIndexData(){
        $res_data = [];
        $today_str = Carbon::parse('today')->format('Y-m-d').' 00:00:00';
        $today_register = UserLog::where(
            [
                ['created_at','>=',$today_str],
                ['type','=','auth'],
                ['action','=','register']
            ]
        )->count();
        $today_inquiry = UserLog::where(
            [
                ['created_at','>=',$today_str],
                ['type','=','inquiry'],
                ['action','=','create'],
            ]
        )->count();

        $today_product = AdminLog::where(
            [
                ['created_at','>=',$today_str],
                ['type','=','audit_product'],
                ['action','=','approved'],
            ]
        )->count();

        $today_data = compact('today_register','today_inquiry','today_product');
        $res_data['today_data'] = $today_data;

        $total_register = UserLog::where(
            [
                ['type','=','auth'],
                ['action','=','register']
            ]
        )->count();
        $total_inquiry = UserLog::where(
            [
                ['type','=','inquiry'],
                ['action','=','create'],
            ]
        )->count();
        $total_product = AdminLog::where(
            [
                ['type','=','audit_product'],
                ['action','=','approved'],
            ]
        )->count();

        $total_data = compact('total_register','total_inquiry','total_product');
        $res_data['total_data'] = $total_data;


        $seven_data = [];
        $seven_data['new_user'] =[];
        $seven_data['new_inquiry'] =[];
        $seven_data['new_admin_count'] =[];

        for($i=6;$i>=0;$i--){
            $carbon_day_obj = Carbon::parse('today')->parse("-$i days");
            $to_day_start = clone $carbon_day_obj;
            $to_day_end = clone $carbon_day_obj;
            $day = clone $carbon_day_obj;

            $to_day_start = $to_day_start->format('Y-m-d').' 00:00:00';
            $to_day_end = $to_day_end->format('Y-m-d').' 23:59:59';
            $new_user_count = UserLog::where(
                [
                    ['created_at','>=',$to_day_start],
                    ['created_at','<=',$to_day_end],
                    ['type','=','auth'],
                    ['action','=','register'],
                ]
            )->count();
            $new_inquiry_count = UserLog::where(
                [
                    ['created_at','>=',$to_day_start],
                    ['created_at','<=',$to_day_end],
                    ['type','=','inquiry'],
                    ['action','=','create'],
                ]
            )->count();
            $new_admin_count = AdminLog::where(
                [
                    ['created_at','>=',$to_day_start],
                    ['created_at','<=',$to_day_end],
                    ['type','=','auth'],
                    ['action','=','register'],
                ]
            )->count();

            $day = $day->format('Y-m-d');
            $seven_data['new_user'][$day] = $new_user_count;
            $seven_data['new_inquiry'][$day] = $new_inquiry_count;
            $seven_data['new_admin_count'][$day] = $new_admin_count;
        }

        $res_data['seven_day_data'] = $seven_data;

        return $this->echoSuccessJson('成功!',$res_data);

    }

}
