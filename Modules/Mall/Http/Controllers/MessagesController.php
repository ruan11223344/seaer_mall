<?php

namespace Modules\Mall\Http\Controllers;

use App\Utils\EchoJson;
use App\Utils\EMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Service\UtilsService;
use Modules\Mall\Entities\InquiryMessages;
use Modules\Mall\Entities\InquiryParticipants;
use Modules\Mall\Entities\InquiryThreads;
use Modules\Mall\Entities\Products;
use Modules\Mall\Entities\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use Modules\Mall\Entities\UsersExtends;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{

    const KE_COUNTRY_ID = 56;
    const CHINA_COUNTRY_ID = 101;

    use EchoJson;

    static function extraRequestToStr($object){
        $str = '';
        if($object !== null){
            foreach ($object as $value){
                foreach ($value as $key=>$v){
                    if($v == true){
                        $str.=$key.',';
                    }
                }
            }
        }
        $str =rtrim($str, ',');
        return $str;
    }

    public static function getAllowInquiry(){
        return Auth::user()->usersExtends->allow_inquiry;
    }

    public static function getAttachmentListUrl($attachment_data){
        $res_data = [];
        if(count($attachment_data) > 0){
            foreach ($attachment_data as $v){
                $res_data[] = UtilsController::getPathFileUrl($v);
            }
        }
        return $res_data;
    }

    public function sendMailNotification($to_user_id,$what_message,$message_info,$is_reply = false){
        $to_user_ex = UsersExtends::where('user_id',$to_user_id)->first();
        $inquiry_url = 'http://'.env('MALL_DOMAIN')."/inquiryList/inbox";
        $logo_url = asset('/img/logo.png');
        $message_form_name = $message_info['message_form_name'];
        $message_to_name = $message_info['message_to_name'];
        $message_to_company = $message_info['message_to_company'];

        if($to_user_ex->email_notification){
            $email_obj = new EMail();
            $subject = $is_reply ? 'RE: ' . '你有一条新的询盘消息!' : '你有一条新的询盘消息!';
            $email_obj->send(User::find($to_user_id)->email,$subject,compact('what_message','inquiry_url','logo_url','message_form_name','message_to_name','message_to_company'),$email_obj::TEMPLATE_MESSAGE);
        }
    }

    public function messageListInfo($data){
        $res_data = [];
        if($data != null){
            if(count($data) > 0){
                foreach ($data as $key=>$value){
                    $tmp_data = [];
                    $user_extends = UsersExtends::where('user_id',$value->user_id)->first();
                    $participant = InquiryParticipants::where('thread_id',$value->thread->id)->where('extends->message_id',$value->id)->first();
                    $to_user_id = $participant->user_id;
                    $to_user_extends = UsersExtends::where('user_id',$to_user_id)->first();
                    $tmp_data['subject'] = $value->thread->subject;
                    $tmp_data['message_id'] = $value->id;
                    $tmp_data['thread_id'] = $value->thread_id;
                    $tmp_data['send_at'] = $value->created_at;
                    $tmp_data['send_from_ip'] = $value->extends['from_ip'];
                    $tmp_data['send_by_af_id'] = $user_extends->af_id;
                    $tmp_data['send_to_af_id'] = $to_user_extends->af_id;
                    $tmp_data['send_by_name'] = $user_extends->contact_full_name;
                    $tmp_data['send_to_name'] = $to_user_extends->contact_full_name;
                    $tmp_data['send_country'] = $user_extends->country_id == self::KE_COUNTRY_ID ? 'ke' : 'cn';
                    $tmp_data['other_party_is_read'] = $participant->last_read == null ? false : true;
                    $tmp_data['other_party_is_reply'] = $participant->extends['is_reply'];
                    $tmp_data['is_flag'] = $value->extends['is_flag'];
                    $tmp_data['type'] = 'outbox';
                    array_push($res_data,$tmp_data);
                }
            }

        }
        return $res_data;
    }

    public function participantListInfo($data){
        $res_data = [];
        if(count($data) > 0 ){
            foreach ($data as $key=>$value){
                $tmp_data = [];
                $message = InquiryMessages::find($value->extends['message_id']);
                $from_user_extends = UsersExtends::where('user_id',$message->user_id)->first();
                $tmp_data['subject'] = $value->thread->subject;
                $tmp_data['message_id'] = $value->extends['message_id'];
                $tmp_data['participant_id'] = $value->id;
                $tmp_data['thread_id'] = $value->thread->id;
                $tmp_data['send_at'] = $message->created_at;
                $tmp_data['is_read'] = $value->last_read == null ? false : true;
                $tmp_data['is_reply'] = $value->extends['is_reply'];
                $tmp_data['from_other_party_reply'] = $value->extends['from_other_party_reply'];
                $tmp_data['send_from_ip'] =$message->extends['from_ip'];
                $tmp_data['send_by_af_id'] = $from_user_extends->af_id;
                $tmp_data['send_by_name'] = $from_user_extends->contact_full_name;
                $tmp_data['send_country'] = $from_user_extends->country_id == self::KE_COUNTRY_ID ? 'ke' : 'cn';
                $tmp_data['is_flag'] = $value->extends['is_flag'];
                $tmp_data['type'] = 'inbox';
                array_push($res_data,$tmp_data);
            }
        }

        return $res_data;
    }

    public function participantInfo($data){
        $res_data = [];
        if(count($data) > 0 ){
            foreach ($data as $key=>$value){
                $tmp_data = [];
                $message = InquiryMessages::find($value->extends['message_id']);
                $from_user_extends = UsersExtends::where('user_id',$message->user_id)->first();
                $purchase_info = json_decode($value->thread->extends);
                $tmp_data['subject'] = $value->thread->subject;
                $tmp_data['content'] =$message->body;
                $tmp_data['message_id'] = $value->extends['message_id'];
                $tmp_data['participant_id'] = $value->id;
                $tmp_data['thread_id'] = $value->thread->id;
                $tmp_data['send_at'] = $message->created_at;
                $tmp_data['send_from_ip'] =$message->extends['from_ip'];
                $tmp_data['send_by_af_id'] = $from_user_extends->af_id;
                $tmp_data['send_by_name'] = $from_user_extends->contact_full_name;
                $tmp_data['send_country'] = $from_user_extends->country_id == self::KE_COUNTRY_ID ? 'ke' : 'cn';
                $tmp_data['extra_request'] = self::extraRequestToStr(json_decode($value->thread->extends)->extra_request);
                $tmp_data['purchase_quantity'] =  $purchase_info->purchase_quantity.' '.$purchase_info->purchase_unit;

                if(isset($purchase_info->product_id)){
                    $product_id = $purchase_info->product_id;
                    $product  = Products::find($product_id);
                }else{
                    $product = null;
                    $product_id = null;
                }
                $tmp_data['product_id'] =  $product_id;
                $tmp_data['product_name'] =  $product_id != null && $product != null ? $product->product_name : null;
                $tmp_data['product_main_pic'] =  $product_id != null && $product != null ? \Modules\Mall\Http\Controllers\UtilsController::getPathFileUrl($product->product_images[0]['main']) : null;

                $tmp_data['attachment_list'] = $message->extends['attachment_list'];
                $tmp_data['attachment_list_url'] = self::getAttachmentListUrl($message->extends['attachment_list']);
                $tmp_data['type'] = 'inbox';
                array_push($res_data,$tmp_data);
            }
        }

        return $res_data;
    }

    public function messageInfo($data){
        $res_data = [];
        if($data != null){
            if(count($data) > 0){
                foreach ($data as $key=>$value){
                    $tmp_data = [];
                    $user_extends = UsersExtends::where('user_id',$value->user_id)->first();
                    $participant = InquiryParticipants::where('thread_id',$value->thread->id)->where('extends->message_id',$value->id)->first();
                    $to_user_id = $participant->user_id;
                    $to_user_extends = UsersExtends::where('user_id',$to_user_id)->first();
                    $purchase_info = json_decode($value->thread->extends);
                    $tmp_data['subject'] = $value->thread->subject;
                    $tmp_data['content'] = $value->body;
                    $tmp_data['message_id'] = $value->id;
                    $tmp_data['thread_id'] = $value->thread_id;
                    $tmp_data['send_at'] = $value->created_at;
                    $tmp_data['send_from_ip'] = $value->extends['from_ip'];
                    $tmp_data['send_by_af_id'] = $user_extends->af_id;
                    $tmp_data['send_to_af_id'] = $to_user_extends->af_id;
                    $tmp_data['send_by_name'] = $user_extends->contact_full_name;
                    $tmp_data['send_to_name'] = $to_user_extends->contact_full_name;
                    $tmp_data['send_country'] = $user_extends->country_id == self::KE_COUNTRY_ID ? 'ke' : 'cn';
                    $tmp_data['extra_request'] = self::extraRequestToStr(json_decode($value->thread->extends)->extra_request);
                    $tmp_data['purchase_quantity'] =  $purchase_info->purchase_quantity.' '.$purchase_info->purchase_unit;
                    if(isset($purchase_info->product_id)){
                        $product_id = $purchase_info->product_id;
                        $product  = Products::find($product_id);
                    }else{
                        $product = null;
                        $product_id = null;
                    }
                    $tmp_data['product_id'] =  $product_id;
                    $tmp_data['product_name'] =  $product_id != null && $product != null ? $product->product_name : null;
                    $tmp_data['product_main_pic'] =  $product_id != null && $product != null ? \Modules\Mall\Http\Controllers\UtilsController::getPathFileUrl($product->product_images[0]['main']) : null;
                    $attachment_list = $value->extends['attachment_list'];
                    $tmp_data['attachment_list'] = count($attachment_list) == 0 ? null : $attachment_list;
                    $tmp_data['attachment_list_url'] = self::getAttachmentListUrl($attachment_list);
                    $quote_message = $this->messageInfo(InquiryMessages::where('id',$value->extends['quote_message_id'])->where('extends->soft_deleted_at','=',false)->where('extends->true_deleted_at','=',false)->get());
                    $tmp_data['quote_message'] = count($quote_message) == 0 ? null : $quote_message;
//                    $tmp_data['is_flag'] = $value->extends['is_flag'];
//                    $tmp_data['type'] = 'outbox';
                    array_push($res_data,$tmp_data);
                }
            }

        }
        return $res_data;
    }

    public function createMessage(Request $request){
        if(self::getAllowInquiry() == false){
            return $this->echoErrorJson('您被禁止使用询盘功能!');
        }
        $this->function_name = 'createMessage';
        $user_id = Auth::id();
        $data = $request->all();

        Validator::extend('extra_request_object', function($attribute, $value, $parameters)
        {
            try{
                if(count($value) == 0){
                    return true;
                }
                foreach($value as $v) {
                    if(json_decode($v) == null){
                        return false;
                    }
                }
            }catch (Exception $e){
                return false;
            }
            return true;
        });

        $validator = Validator::make($data, [
            'to_af_id'=>'exists:users_extends,af_id',
            'subject'=>'required',
            'extra_request'=>'array|extra_request_object',
            'purchase_quantity'=>'required|integer',
            'purchase_unit'=>'required',
            'product_id'=>'nullable|exists:products,id,deleted_at,NULL',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $subject = $request->input('subject');
        $body = $request->input('content');
        $re_thread =InquiryThreads::where('subject',$subject)->orderBy('created_at','desc')->first();
        $to_af_id = $request->input('to_af_id');
        $to_user_id = UtilsController::getUserIdFormAfId($to_af_id);


        if($re_thread != null){
            $re_message= InquiryMessages::where('thread_id',$re_thread->id)->first();
            $re_body= $re_message->body;
            $re_participant = InquiryParticipants::where('thread_id',$re_thread->id)->first();
            $re_user_id = $re_participant->user_id;
            if($re_body == $body && $re_user_id == $to_user_id){
                return $this->echoErrorJson('Failure!The same message cannot occur to the same user!',[]);
            }
        }


        $files = $request->file('attachment_list');

        if($files != null){
            $attachments = UtilsController::uploadMultipleFile($files,UtilsController::getUserAttachmentDirectory(),true,true);
        }else{
            $attachments = [];
        }

        try{
            DB::beginTransaction();

            $extra_request_list = $request->input('extra_request',null);
            if($extra_request_list != null && is_array($extra_request_list)){
                foreach ($extra_request_list as $key=>$value){
                    $extra_request_list[$key] = json_decode($value);
                }
            }

            $product_id = $request->input('product_id',null);

            $thread = InquiryThreads::create([
                'subject' => $subject,
                'extends'=>[
                    'extra_request'=>$extra_request_list,
                    'purchase_quantity'=>$request->input('purchase_quantity',null),
                    'purchase_unit'=>$request->input('purchase_unit',null),
                    'product_id'=>$product_id,
                ],
            ]);


            $ip = $request->getClientIp();

            $message = InquiryMessages::create([
                'thread_id' => $thread->id,
                'user_id' =>$user_id,
                'body' => $body,
                'extends'=>[
                    'soft_deleted_at'=>false,
                    'true_deleted_at'=>false,
                    'attachment_list'=>$attachments,
                    'from_ip'=>substr($ip,0,strrpos($ip,'.')).".*",
                    'quote_message_id'=>null,
                    'is_flag'=> false,
                ],
            ]);


            InquiryParticipants::create([
                'thread_id' => $thread->id,
                'user_id' => $to_user_id,
                'last_read' => null,
                'extends'=>[
                    'is_reply' => false,
                    'from_other_party_reply'=>false,
                    'soft_deleted_at' => false,
                    'true_deleted_at'=>false,
                    'is_flag'=> false,
                    'is_spam'=> false,
                    'message_id'=> $message->id,
                ],
            ]);
            UtilsService::WriteLog('user','inquiry','create',$user_id,$message->id);
            DB::commit();

            $form_userEx = User::find($user_id)->usersExtends;
            $message_info['message_form_name'] = $form_userEx->sex.$form_userEx->contact_full_name;
            $to_userEx = User::find($to_user_id)->usersExtends;
            $message_info['message_to_name'] =  $to_userEx->sex.$to_userEx->contact_full_name;
            $message_info['message_to_company'] = User::find($to_user_id)->company->company_name;


            $this->sendMailNotification($to_user_id,$subject,$message_info);
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('Publishing message failed!',[$e->getMessage()]);
        }
        return $this->echoSuccessJson('The message was published successfully!',$thread->toArray());
    }

    public function deleteMessage(){
        $user_id = Auth::id();
        $participant = InquiryParticipants::where('user_id',$user_id)->where('extends->soft_deleted_at','!=',false)->where('extends->true_deleted_at','=',false)->get();
        $message = InquiryMessages::where('user_id',$user_id)->where('extends->soft_deleted_at','!=',false)->where('extends->true_deleted_at','=',false)->get();
        $message_data = $this->messageListInfo($message);
        $participant_data = $this->participantListInfo($participant);
        return $this->echoSuccessJson('Success!',array_merge($message_data,$participant_data));
    }

    public function replyMessage(Request $request){
        if(self::getAllowInquiry() == false){
            return $this->echoErrorJson('您被禁止使用询盘功能!');
        }
        $this->function_name = 'replyMessage';
        $data = $request->all();
        $validator = Validator::make($data, [
            'message_id'=>'exists:inquiry_messages,id',
            'quote_message_id'=>'exists:inquiry_messages,id|nullable'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $form_message_id = $request->input('message_id');
        $from_message = InquiryMessages::find($form_message_id);

        $user_id = Auth::id();


        $re_message = InquiryMessages::where('user_id',$user_id)->orderBy('created_at','desc')->get()->first(); //找到最近一条发送的消息
        if($re_message != null){
            $re_body = $re_message->body; //最近一条发送的内容
        }else{
            $re_body = null;
        }

        $content = $request->input('content');  //准备发送的内容
        $to_user_id = $from_message->user_id; //要回复的user_id

        if($re_body == $content){
            if(InquiryParticipants::where('extends->message_id',(integer)$re_message->id)->get()->first()->user_id == $to_user_id){
                return $this->echoErrorJson('You cannot send duplicate messages to the same user!',[]);
            }
        }

        try{
            DB::beginTransaction();
            //标记为已回复
            InquiryParticipants::where('thread_id',$from_message->thread->id)->where('extends->message_id',(integer)$form_message_id)->get()->map(function ($item){
                $item->forceFill(['extends->is_reply'=>true])->save();
            });

            $files = $request->file('attachment_list');

            if($files != null){
                $attachments = UtilsController::uploadMultipleFile($files,UtilsController::getUserAttachmentDirectory(),true,true);
            }else{
                $attachments = [];
            }


            $ip = $request->getClientIp();

            $message = InquiryMessages::create([
                'thread_id' => $from_message->thread_id,
                'user_id' =>$user_id,
                'body' =>$content,
                'extends'=>[
                    'soft_deleted_at'=>false,
                    'true_deleted_at'=>false,
                    'attachment_list'=>$attachments,
                    'from_ip'=>substr($ip,0,strrpos($ip,'.')).".*",
                    'quote_message_id'=>$request->input('quote_message_id',null),
                    'is_flag'=>false,
                ],
            ]);

            $subject = $message->thread->subject;




            InquiryParticipants::create([
                'thread_id' => $from_message->thread_id,
                'user_id' => $to_user_id,
                'last_read' => null,
                'extends'=>[
                    'is_reply' => false,
                    'from_other_party_reply'=>true,
                    'soft_deleted_at' => false,
                    'true_deleted_at'=>false,
                    'is_flag'=> false,
                    'is_spam'=> false,
                    'message_id'=> $message->id,
                ],
            ]);
            UtilsService::WriteLog('user','inquiry','create',$user_id,$message->id);
            DB::commit();
            $message_info = [];
            $form_userEx = User::find($user_id)->usersExtends;
            $message_info['message_form_name'] = $form_userEx->sex.$form_userEx->contact_full_name;
            $to_userEx = User::find($to_user_id)->usersExtends;
            $message_info['message_to_name'] =  $to_userEx->sex.$to_userEx->contact_full_name;
            $message_info['message_to_company'] = User::find($to_user_id)->company->company_name;

            $this->sendMailNotification($to_user_id,$subject,$message_info,true);
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('Respond to failure!',[$e->getMessage()]);
        }
        return $this->echoSuccessJson('Success!',[]);
    }

    public function outboxMessage(){
        $msg = InquiryMessages::where('user_id',Auth::id())->where('extends->soft_deleted_at',false);
        $unread = [];
        $read = [];
        $un_reply = [];
        $all = $this->messageListInfo($msg->get());

        if(count($all) > 0 ){
            foreach ($all as $value){
                if($value['other_party_is_read'] == true){
                    array_push($read,$value);
                }elseif($value['other_party_is_read'] == false){
                    array_push($unread,$value);
                }

                if($value['other_party_is_reply'] == false){
                    array_push($un_reply,$value);
                }
            }
        }

        return $this->echoSuccessJson('Success!',compact('all','unread','read','un_reply'));
    }

    public function inboxMessage(){
        $this->autoMarkSpamMessage();
        $participant = InquiryParticipants::where('user_id',Auth::id())->where('extends->soft_deleted_at',false)->where('extends->is_spam',false);
        $all = $this->participantListInfo($participant->get());
        $unread = [];
        $pending_for_reply = [];
        if(count($all) > 0){
            foreach ($all as $value){
                if($value['is_read'] == false){
                    array_push($unread,$value);
                }
                if($value['is_reply'] == false){
                    array_push($pending_for_reply,$value);
                }
            }
        }

        return $this->echoSuccessJson('Success!',compact('all','unread','pending_for_reply'));
    }

    public function spamMessage(){
        $orm_build = InquiryParticipants::where('user_id',Auth::id())->where('extends->soft_deleted_at',false)->where('extends->is_spam',true);
        $all = $this->participantListInfo($orm_build->get());
        return $this->echoSuccessJson('Success!',compact('all'));
    }

    public function flagMessage(){
        $id = Auth::id();
        $outbox = InquiryMessages::where('user_id',$id)->where('extends->soft_deleted_at',false)->where('extends->is_flag',true)->get();
        $inbox = InquiryParticipants::where('user_id',$id)->where('extends->soft_deleted_at',false)->where('extends->is_flag',true)->get();
        $outbox_data = $this->messageListInfo($outbox);
        $inbox_data = $this->participantListInfo($inbox);
        $all = array_merge($outbox_data,$inbox_data);
        return $this->echoSuccessJson('Success!',compact('all'));
    }
    
    public function markFlagMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'participant_id'=>'exists:inquiry_participants,id|required_if:type,inbox',
            'message_id'=>'exists:inquiry_messages,id|required_if:type,outbox',
            'type'=>'in:inbox,outbox'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $action = $request->input('action');
        $user_id = Auth::id();
        if($request->input('type') == 'inbox'){
            $participant_id = $request->input('participant_id');
            $rom_build = InquiryParticipants::where('user_id',$user_id)->where('id',$participant_id)->get();
        }elseif ($request->input('type') == 'outbox'){
            $message_id = $request->input('message_id');
            $rom_build = InquiryMessages::where('user_id',$user_id)->where('id',$message_id)->get();
        }

        $rom_build->map(function ($item)use($action){
            $item->forceFill(['extends->is_flag'=> $item->extends['is_flag'] ? false : true]);
            $item->save();
        });

        return $this->echoSuccessJson('Success!',[$rom_build]);
    }

    public function markSpamMessage(Request $request){
        $data = $request->all();

        Validator::extend('thread_in_table', function($attribute, $value, $parameters)
        {
            foreach($value as $v) {
                if(InquiryThreads::find($v) == null){
                    return false;
                }
            }
            return true;
        });

        $validator = Validator::make($data,[
            'thread_id_list'=>'thread_in_table|required|array|min:1',
            'action'=>'in:mark,cancel|required',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $thread_id_list = $request->input('thread_id_list');
        $user_id = Auth::id();
        $action = $request->input('action');

        $spam_user_id_list = InquiryMessages::whereIn('thread_id',$thread_id_list)->get()->pluck('user_id')->toArray();

        $spam_user_id_list = array_unique($spam_user_id_list);



        InquiryParticipants::where('user_id',$user_id)->get()->map(function ($item) use($spam_user_id_list,$action){
            $message_id = $item->extends['message_id'];
            $spam_user_id = InquiryMessages::find($message_id)->user_id;
            if(in_array($spam_user_id,$spam_user_id_list)){
                $item->forceFill(['extends->is_spam'=> $action == 'mark' ? true : false]);
                $item->save();
            }
        });

        return $this->echoSuccessJson('Success!',[]);
    }

    public function markDeleteMessage(Request $request){
        $data = $request->all();

        Validator::extend('participant_in_table', function($attribute, $value, $parameters)
        {
            if($value == null){
                return true;
            }

            if(count($value) > 0 && !empty($value[0])){
                foreach($value as $v) {
                    if(InquiryParticipants::find($v) == null){
                        return false;
                    }
                }
            }
            return true;
        });

        Validator::extend('message_in_table', function($attribute, $value, $parameters)
        {

            if(count($value) > 0  && !empty($value[0])){
            foreach($value as $v) {
                if(InquiryMessages::find($v) == null){
                    return false;
                }
            }
        }
            return true;
        });

        $validator = Validator::make($data,[
            'participants_id_list'=>'participant_in_table|array',
            'messages_id_list'=>'message_in_table|array',
            'action'=>'in:mark,cancel|required',
            'type'=>'in:inbox,outbox|required'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $type = $request->input('type');
        $action = $request->input('action');

        $user_id = Auth::id();


        if($type == 'inbox'){
            $participant_id_list = $request->input('participants_id_list');
            if($participant_id_list !== null){
                InquiryParticipants::whereIn('id',$participant_id_list)->where('user_id',$user_id)->get()->map(function ($item)use ($action){
                    $item->forceFill(['extends->soft_deleted_at'=>$action == 'mark' ? Carbon::now()->toDateTimeString() :false]);
                    $item->save();
                });
            }
        }elseif ($type == 'outbox'){
            $message_id_list = $request->input('messages_id_list');
            if($message_id_list !== null){
                InquiryMessages::whereIn('id',$message_id_list)->where('user_id',$user_id)->get()->map(function ($item)use ($action){
                    $item->forceFill(['extends->soft_deleted_at'=>$action == 'mark' ? Carbon::now()->toDateTimeString() :false]);
                    $item->save();
                });
            }
        }

        return $this->echoSuccessJson('Operation Success!');
    }

    public function markReadMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'participant_id'=>'exists:inquiry_participants,id|required',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }
        $participant_id = $request->input('participant_id');

        InquiryParticipants::where('user_id',Auth::id())->where('id',$participant_id)->update(['last_read'=>Carbon::now()->toDateTimeString()]);
        return $this->echoSuccessJson('Success!',[]);
    }

    public function confirmDeleteMessage(Request $request){
        $data = $request->all();
        Validator::extend('participant_in_table', function($attribute, $value, $parameters)
        {
            if(count($value) > 0 && !empty($value[0])){
                foreach($value as $v) {
                    if(InquiryParticipants::find($v) == null){
                        return false;
                    }
                }
            }
            return true;
        });

        Validator::extend('message_in_table', function($attribute, $value, $parameters)
        {
            if(count($value) > 0 && !empty($value[0])){
                foreach($value as $v) {
                    if(InquiryMessages::find($v) == null){
                        return false;
                    }
                }
            }
            return true;
        });

        $validator = Validator::make($data,[
            'participants_id_list'=>'required|participant_in_table|array',
            'messages_id_list'=>'required|message_in_table|array',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }


        $user_id = Auth::id();
        InquiryParticipants::where('user_id',$user_id)->where('extends->soft_deleted_at','!=',false)->whereIn('id',$request->input('participants_id_list'))->get()->map(
            function ($item){
                $item->forceFill(['extends->true_deleted_at'=>Carbon::now()->toDateTimeString()]);
                $item->save();
            }
        );

        InquiryMessages::where('user_id',$user_id)->where('extends->soft_deleted_at','!=',false)->whereIn('id',$request->input('messages_id_list'))->get()->map(
            function ($item){
                $item->forceFill(['extends->true_deleted_at'=>Carbon::now()->toDateTimeString()]);
                $item->save();
            }
        );
        return $this->echoSuccessJson('Delete Success permanently!',[]);
    }

    public function autoMarkSpamMessage(){
        $user_id = Auth::id();
        $spam_user_id_list = [];
        InquiryParticipants::where('user_id',$user_id)->where('extends->is_spam',true)->get()->map(
            function ($item)use($spam_user_id_list){
                $message_id = $item->extends['message_id'];
                $spam_user_id = InquiryMessages::find($message_id)->user_id;
                array_push($spam_user_id_list,$spam_user_id);
            }
        );

        $spam_user_id_list = array_unique($spam_user_id_list);

        InquiryParticipants::where('user_id',$user_id)->get()->map(function ($item)use($spam_user_id_list){
            $message_id = $item->extends['message_id'];
            $spam_user_id = InquiryMessages::find($message_id)->user_id;
            if(in_array($spam_user_id,$spam_user_id_list)){
                $item->forceFill(['extends->is_spam'=> true]);
                $item->save();
            }
        });
    }

    public function getMessageInfo(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'participant_id'=>'exists:inquiry_participants,id|required_if:type,inbox',
            'message_id'=>'exists:inquiry_messages,id|required_if:type,outbox',
            'type'=>'in:inbox,outbox'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('Form validation failed!'.$validator->messages());
        }

        $type = $request->input('type');

        $user_id = Auth::id();

        if($type == 'inbox'){
            $participant_id = $request->input('participant_id');
           $data =  InquiryParticipants::where('user_id',$user_id)->where('id',$participant_id)->get();
           $res_data = $this->participantInfo($data);
        }elseif ($type == 'outbox'){
            $message_id = $request->input('message_id');
            $data = InquiryMessages::where('user_id',$user_id)->where('id',$message_id)->get();
            $res_data = $this->messageInfo($data);
        }

        if(count($res_data) == 0){
            return $this->echoErrorJson('Failure!No messages were received',[]);
        }

        return $this->echoSuccessJson('Success!',$res_data);
    }

    public function emailNotificationStatus(){
        $res = Auth::user()->usersExtends->email_notification;
        return $this->echoSuccessJson('Gets the mailbox notification status Success!',['email_notification'=>$res]);
    }

    public function setEmailNotification(){
        $user_extends = Auth::user()->usersExtends;
        $res = $user_extends->email_notification;
        $user_extends->email_notification = $res ? false : true;
        $user_extends->save();
        return $this->echoSuccessJson('successfully set!');
    }

}
