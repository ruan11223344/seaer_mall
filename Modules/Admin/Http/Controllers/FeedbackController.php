<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Feedback;
use Modules\Mall\Entities\User;
use App\Utils\EchoJson;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    use EchoJson;
    public function getFeedbackList(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'page'=>'required|integer',
            'size'=>'required|integer',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $page = $request->input('page',1);
        $size = $request->input('size',20);
        $feedback = new Feedback();
        $count = Feedback::count();
        $data_list =[];
        $feedback->offset(($page-1)*$size)->limit($size)->get()->map(function ($v,$k)use(&$data_list,$page,$size){
            $tmp = [];
            $tmp['num'] = $k+1+(($page-1)*$size);
            $tmp['feedback_id'] = $v->id;
            $user = User::find($v->user_id);
            $tmp['add_time'] = Carbon::parse($v->created_at)->format('Y-m-d H:i:s');
            $tmp['member_id'] = $user != null ? $user->name : '';
            $tmp['contact_way'] =$v->contact_way;
            $tmp['user_message'] =$v->user_message;
            $tmp['user_type_str'] =$user != null ? "注册用户" : "访客" ;
            if($v->is_spam){
                $status_str = "垃圾反馈";
            }elseif ($v->is_process){
                $status_str = "已处理";
            }else{
                $status_str = "未处理";
            }
            $tmp['status_str'] =$status_str;
            $tmp['is_process'] =$v->is_process;
            $tmp['is_spam'] =$v->is_spam;
            $data_list[] = $tmp;
        });
        $res_data['data'] = $data_list;
        $res_data['size'] = $size;
        $res_data['cur_page'] =$page;
        $res_data['total_page'] = (int)ceil($count/$size);
        $res_data['total_size'] = $count;

        return $this->echoSuccessJson('获取回馈列表成功!',$res_data);
    }

    public static function userPubFeedback($message,$user_id,$contact_way){
        $res = Feedback::create([
           'user_id'=>$user_id,
           'user_message'=>$message,
           'contact_way'=>$contact_way,
           'is_process'=>false,
        ]);

        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function processFeedback(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'feedback_id'=>'required|exists:feedback,id',
            'is_spam'=>'boolean|required',
            'admin_message'=>'nullable',
            //'system_article','system_announcement','user_agreements'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $feedback_id = $request->input('feedback_id');
        $is_spam = $request->input('is_spam');
        $admin_message = $request->input('admin_message',null);

        $feedback = Feedback::find($feedback_id);


        if($feedback == null){
            return $this->echoErrorJson('错误!该条反馈不存在!');
        }

        if($feedback->is_process == true || $feedback->is_spam != null){
            return $this->echoErrorJson('错误!该条反馈已经处理过了!');
        }

        if($admin_message == null && $is_spam != true){
            return $this->echoErrorJson('错误!非垃圾反馈必须填写反馈结果信息!');
        }

        $feedback->is_spam = $is_spam;
        if($admin_message != null){
            $feedback->admin_message = $admin_message;
        }
        $feedback->is_process = true;
        $feedback->save();

        return $this->echoSuccessJson('处理成功!',$feedback->toArray());
    }
}