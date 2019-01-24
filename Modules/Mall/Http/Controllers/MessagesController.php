<?php

namespace Modules\Mall\Http\Controllers;

use App\Utils\EchoJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Mall\Entities\InquiryMessages;
use Modules\Mall\Entities\InquiryParticipants;
use Modules\Mall\Entities\InquiryThreads;
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
    protected $mail_notification = [];
    protected $function_name = null;

    const KE_COUNTRY_ID = 56;
    const CHINA_COUNTRY_ID = 101;

    public function __destruct()
    {
        if($this->function_name == 'createMessage' || $this->function_name == 'replyMessage'){
            foreach ($this->mail_notification as $user_id){
                if(UsersExtends::where(['user_id'=>$user_id,'email_notification'=>true])->get() !== null){
                    $this->sendMailNotification();
                }
            }
        }
    }

    const MSG_EX = [

    ];

    const PARTICIPANTS_EX = [

    ];

    const THREAD_EX = [
        'purchase_quantity',
        'purchase_unit',
        'extra_request',
        'reply_to_email',
        'attachment_list'
    ];

    use EchoJson;
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */

    public function sendMailNotification(){

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
                    $tmp_data['extra_request'] = json_decode($value->thread->extends)->extra_request;
                    $tmp_data['purchase_quantity'] =  $purchase_info->purchase_quantity.' '.$purchase_info->purchase_unit;
                    $tmp_data['attachment_list'] = $value->extends['attachment_list'];
                    $tmp_data['other_party_is_read'] = $participant->last_read == null ? false : true;
                    $tmp_data['other_party_is_reply'] = $participant->extends['is_reply'];
                    $tmp_data['quote_message'] = $this->messageInfo(InquiryMessages::where('id',$value->extends['quote_message_id'])->where('extends->soft_deleted_at','=',false)->where('extends->true_deleted_at','=',false)->get());
                    $tmp_data['type'] = 'outbox';
                    array_push($res_data,$tmp_data);
                }
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
                $tmp_data['is_read'] = $value->last_read == null ? false : true;
                $tmp_data['is_reply'] = $value->extends['is_reply'];
                $tmp_data['send_from_ip'] =$message->extends['from_ip'];
                $tmp_data['send_by_af_id'] = $from_user_extends->af_id;
                $tmp_data['send_by_name'] = $from_user_extends->contact_full_name;
                $tmp_data['send_country'] = $from_user_extends->country_id == self::KE_COUNTRY_ID ? 'ke' : 'cn';
                $tmp_data['extra_request'] = json_decode($value->thread->extends)->extra_request;
                $tmp_data['purchase_quantity'] =  $purchase_info->purchase_quantity.' '.$purchase_info->purchase_unit;
                $tmp_data['attachment_list'] = $message->extends['attachment_list'];
                $tmp_data['type'] = 'inbox';
                array_push($res_data,$tmp_data);
            }
        }

        return $res_data;
    }


    public function createMessage(Request $request){
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
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $files = $request->file('attachment_list');

        if($files != null){
            $attachments = UtilsController::uploadMultipleFile($files,UtilsController::getUserAttachmentDirectory(),true);
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


            $thread = InquiryThreads::create([
                'subject' => $request->input('subject'),
                'extends'=>[
                    'extra_request'=>$extra_request_list,
                    'purchase_quantity'=>$request->input('purchase_quantity',null),
                    'purchase_unit'=>$request->input('purchase_unit',null),
                ],
            ]);


            $ip = $request->getClientIp();

            $message = InquiryMessages::create([
                'thread_id' => $thread->id,
                'user_id' =>$user_id,
                'body' => $request->input('content'),
                'extends'=>[
                    'soft_deleted_at'=>false,
                    'true_deleted_at'=>false,
                    'attachment_list'=>$attachments,
                    'from_ip'=>substr($ip,0,strrpos($ip,'.')).".*",
                    'quote_message_id'=>null
                ],
            ]);

            $to_af_id = $request->input('to_af_id');

            $to_user_id = UtilsController::getUserIdFormAfId($to_af_id);

            InquiryParticipants::create([
                'thread_id' => $thread->id,
                'user_id' => $to_user_id,
                'last_read' => null,
                'extends'=>[
                    'is_reply' => false,
                    'soft_deleted_at' => false,
                    'true_deleted_at'=>false,
                    'is_flag'=> false,
                    'is_spam'=> false,
                    'message_id'=> $message->id,
                ],
            ]);

            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('发布消息失败!',[$e->getMessage()]);
        }
        return $this->echoSuccessJson('发布消息成功',$thread->toArray());
    }

    public function deleteMessage(){
        $user_id = Auth::id();
        $participant = InquiryParticipants::where('user_id',$user_id)->where('extends->soft_deleted_at','=',true)->where('extends->true_deleted_at','=',false)->get();
        $message = InquiryMessages::where('user_id',$user_id)->where('extends->soft_deleted_at','=',true)->where('extends->true_deleted_at','=',false)->get();
        $message_data = $this->messageInfo($message);
        $participant_data = $this->participantInfo($participant);
        return $this->echoSuccessJson('成功!',array_merge($message_data,$participant_data));
    }


    public function replyMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'message_id'=>'exists:inquiry_messages,id',
            'quote_message_id'=>'exists:inquiry_messages,id|nullable'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $form_message_id = $request->input('message_id');
        try{
            DB::beginTransaction();
            $from_message = InquiryMessages::find($form_message_id)->first();
            //标记为已回复
            InquiryParticipants::where('thread_id',$from_message->thread->id)->where('extends->message_id',(integer)$form_message_id)->first()->forceFill(['extends->is_reply'=>true])->save();

            $content = $request->input('content');

            $files = $request->file('attachment_list');

            if($files != null){
                $attachments = UtilsController::uploadMultipleFile($files,UtilsController::getUserAttachmentDirectory(),true);
            }else{
                $attachments = [];
            }

            $user_id = Auth::id();

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
                    'quote_message_id'=>$request->input('quote_message_id',null)
                ],
            ]);

            $to_user_id = $from_message->user_id;

            InquiryParticipants::create([
                'thread_id' => $from_message->thread_id,
                'user_id' => $to_user_id,
                'last_read' => null,
                'extends'=>[
                    'is_reply' => false,
                    'soft_deleted_at' => false,
                    'true_deleted_at'=>false,
                    'is_flag'=> false,
                    'is_spam'=> false,
                    'message_id'=> $message->id,
                ],
            ]);
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('回复失败!',[$e->getMessage()]);
        }
        return $this->echoSuccessJson('成功!',[]);
    }

    public function outboxMessage(){
        $msg = InquiryMessages::where('user_id',Auth::id())->where('extends->soft_deleted_at',false);
        $unread = [];
        $read = [];
        $all = $this->messageInfo($msg->get());

        if(count($all) > 0 ){
            foreach ($all as $value){
                if($value['other_party_is_read'] == true){
                    array_push($read,$value);
                }else{
                    array_push($unread,$value);
                }
            }
        }

        return $this->echoSuccessJson('成功!',compact('all','unread','read'));
    }

    public function inboxMessage(){
        $this->autoMarkSpamMessage();
        $participant = InquiryParticipants::where('user_id',Auth::id())->where('extends->soft_deleted_at',false)->where('extends->is_spam',false);
        $all = $this->participantInfo($participant->get());
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

        return $this->echoSuccessJson('成功',compact('all','unread','pending_for_reply'));
    }

    public function spamMessage(){
        $orm_build = InquiryParticipants::where('user_id',Auth::id())->where('extends->soft_deleted_at',false)->where('extends->is_spam',true);
        $all = $orm_build->get()->toArray();
        return $this->echoSuccessJson('成功',compact('all'));
    }

    //获取标记为旗帜的消息
    public function flagMessage(){
        $id = Auth::id();
        $outbox = InquiryMessages::where('user_id',$id)->where('extends->is_flag',true)->get()->toArray();
        $inbox = InquiryParticipants::where('user_id',$id)->where('extends->is_flag',true)->get()->toArray();
        $all = array_merge($outbox,$inbox);
        return $this->echoSuccessJson('成功',compact('all'));
    }
    
    public function markFlagMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'participant_id'=>'exists:inquiry_participants,id|nullable',
            'message_id'=>'exists:inquiry_messages,id|nullable',
            'action'=>'in:mark,cancel|required',
            'type'=>'in:inbox:outbox'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $participant_id = $request->input('participant_id');
        $message_id = $request->input('message_id');
        $action = $request->input('action');

        if($request->input('type') == 'inbox'){
            $rom_build = InquiryParticipants::where('user_id',Auth::id())->where('id',$participant_id)->get();
        }elseif ($request->input('type') == 'outbox'){
            $rom_build = InquiryMessages::where('user_id',Auth::id())->where('id',$message_id)->get();
        }

        $rom_build->map(function ($item)use($action){
            $item->forceFill(['extends->is_flag'=> $action == 'mark' ? true : false]);
            $item->save();
        });

        return $this->echoSuccessJson('成功!',[]);
    }

    public function markSpamMessage(Request $request){
        $data = $request->all();

        Validator::extend('thread_in_table', function($attribute, $value, $parameters)
        {
            foreach($value as $v) {
                if(InquiryThreads::find($v) == null) return false;
            }
            return true;
        });

        $validator = Validator::make($data,[
            'thread_id_list'=>'thread_in_table|required|array|min:1',
            'action'=>'in:mark,cancel|required',
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $thread_id = $request->input('thread_id');
        $action = $request->input('action');
        $rom_build = InquiryParticipants::where('user_id',Auth::id())->where('thread_id',$thread_id);

        $rom_build->get()->map(function ($item) use($action){
            $item->forceFill(['extends->is_spam'=> $action == 'mark' ? true : false]);
            $item->save();
        });

        return $this->echoSuccessJson('成功!',[]);
    }

    public function markDeleteMessage(Request $request){
        $data = $request->all();

        Validator::extend('participant_in_table', function($attribute, $value, $parameters)
        {
            if(count($value) > 0){
                foreach($value as $v) {
                    if(InquiryParticipants::find($v) == null) return false;
                }
            }
            return true;
        });

        Validator::extend('message_in_table', function($attribute, $value, $parameters)
        {
            foreach($value as $v) {
                if(InquiryMessages::find($v) == null) return false;
            }
            return true;
        });

        $validator = Validator::make($data,[
            'participants_id_list'=>'participant_in_table',
            'messages_id_list'=>'message_in_table',
            'action'=>'in:mark,cancel|required',
            'type'=>'in:inbox,outbox'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $type = $request->input('type');
        $action = $request->input('action');
        $user_id = Auth::id();
        if($type == 'inbox'){
           $participant_id_list = $request->input('participants_id_list');
            InquiryParticipants::whereIn('id',$participant_id_list)->where('user_id',$user_id)->get()->map(function ($item)use ($action){
                $item->forceFill(['extends->soft_deleted_at'=>$action == 'mark' ? Carbon::now()->toDateTimeString() :false]);
                $item->save();
            });
        }elseif ($type == 'outbox'){
            $messages_id_list = $request->input('messages_id_list');
            InquiryMessages::whereIn('id',$messages_id_list)->where('user_id',$user_id)->get()->map(function ($item)use ($action){
                $item->forceFill(['extends->soft_deleted_at'=>$action == 'mark' ? Carbon::now()->toDateTimeString() :false]);
                $item->save();
            });
        }

        return $this->echoSuccessJson('删除消息成功!',[]);
    }

    public function markReadMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'participant_id'=>'exists:inquiry_participants,id|required',
        ]);


        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }
        $participant_id = $request->input('participant_id');

        InquiryParticipants::where('user_id',Auth::id())->where('id',$participant_id)->update(['last_read'=>Carbon::now()->toDateTimeString()]);
        return $this->echoSuccessJson('成功!',[]);
    }

    public function emptyMessage(){
        $user_id = Auth::id();
        InquiryParticipants::where('user_id',$user_id)->where('extends->soft_deleted_at','=',true)->get()->map(
            function ($item){
                $item->forceFill(['extends->true_deleted_at'=>true]);
                $item->save();
            }
        );

        InquiryMessages::where('user_id',$user_id)->where('extends->soft_deleted_at','=',true)->get()->map(
            function ($item){
                $item->forceFill(['extends->true_deleted_at'=>true]);
                $item->save();
            }
        );
        return $this->echoSuccessJson('清空成功!',[]);
    }

    public function autoMarkSpamMessage(){
        $user_id = Auth::id();
        $thread_id_list = InquiryParticipants::where('user_id',$user_id)->where('extends->is_spam',true)->orderBy('thread_id')->pluck('thread_id');
        InquiryParticipants::where('user_id',$user_id)->whereIn('thread_id',$thread_id_list)->get()->map(function ($item){
            $item->forceFill(['extends->is_spam'=> true]);
            $item->save();
        });
    }

}
