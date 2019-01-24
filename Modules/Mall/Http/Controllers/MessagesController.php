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
    protected $user_id = null;

    public function __construct()
    {
        $this->user_id = Auth::id();
        //todo 消息滥用禁止发送 规则 每天超过100封
    }

    public function __destruct()
    {
        if($this->function_name == 'createMessage' || $this->function_name == 'replyMessage'){
            foreach ($this->mail_notification as $this->user_id){
                if(UsersExtends::where(['user_id'=>$this->user_id,'email_notification'=>true])->get() !== null){
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

    public function MessageListInfo($data){
        foreach ($data as $key=>$value){
            $data[$key]['from_name'] = 1;
            $data[$key]['from_af_id'] = 1;
            $data[$key]['subject'] = 1;
            $data[$key]['country'] = 1;
            $data[$key]['is_read'] = true;
            $data[$key]['is_flag'] = true;
            $data[$key]['other_party_see'] = true;
            $data[$key]['send_time'] = true;
            $data[$key]['send_time_day'] = true;
            $data[$key]['attachment_list'] = true;
            $data[$key]['content'] = true;
            $data[$key]['from_ip'] = true;
            $data[$key]['purchase_quantity'] = true;
            $data[$key]['extra_request'] = true;
            $data[$key]['extra_request'] = true;
        }

        return $data;
    }

    public function createMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'to_af_id'=>'exists:users_extends,af_id',
            'subject'=>'required',
            'extra_request'=>'array|required|nullable',
            'purchase_quantity'=>'required|integer',
            'purchase_unit'=>'required',
        ]);

        if ($validator->fails()){
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $attachments = UtilsController::uploadMultipleFile($request->file('attachment_list'),UtilsController::getUserAttachmentDirectory(),true);

        try{
            DB::beginTransaction();
            $thread = InquiryThreads::create([
                'subject' => $request->input('subject'),
                'extends'=>[
                    'extra_request'=>$request->input('extra_request',null),
                    'purchase_quantity'=>$request->input('purchase_quantity',null),
                    'purchase_unit'=>$request->input('purchase_unit',null),
                    'soft_deleted_at'=>false,
                ],
            ]);


            InquiryMessages::create([
                'thread_id' => $thread->id,
                'user_id' =>$this->user_id,
                'body' => $request->input('content'),
                'extends'=>[
                    'soft_deleted_at'=>false,
                    'attachment_list'=>$attachments,
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
                    'is_flag'=> false,
                    'is_spam'=> false,
                ],
            ]);

            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('发布消息失败!',[$e->getMessage()]);
        }
        return $this->echoSuccessJson('发布消息成功',$thread->toArray());
    }

    public function deleteMessage(Request $request){
        $data = $request->all();

    }

    public function emptyMessage(){
        InquiryParticipants::where('extends->soft_deleted_at','!=',false)->where('user_id',Auth::id())->update(
            ['deleted_at'=>Carbon::now()->toDateTimeString()]
        );
        return $this->echoSuccessJson('清空成功!',[]);
    }

    public function replyMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'thread_id'=>'exists:inquiry_threads,id',
            'quote_message_id'=>'exists:inquiry_messages,id|nullable'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $thread_id = $request->input('thread_id');
        $content = $request->input('content');

        $attachments = UtilsController::uploadMultipleFile($request->file('attachment_list'),UtilsController::getUserAttachmentDirectory(),true);


        InquiryMessages::create([
            'thread_id' => $thread_id,
            'user_id' =>$this->user_id,
            'body' =>$content,
            'extends'=>[
                'soft_deleted_at'=>false,
                'attachment_list'=>$attachments,
                'quote_message_id'=>false,
            ],
        ]);

        $to_user_id = InquiryMessages::where('thread_id',$thread_id)->where('user_id','!=',$this->user_id)->first()->user_id;

        InquiryParticipants::create([
            'thread_id' => $thread_id,
            'user_id' => $to_user_id,
            'last_read' => null,
            'extends'=>[
                'is_reply' => false,
                'soft_deleted_at' => false,
                'is_flag'=> false,
                'is_spam'=> false,
            ],
        ]);

        return $this->echoSuccessJson('成功!',[]);

    }

    public function outboxMessage(){

        $msg = new InquiryMessages();
        $msg_t_name = $msg->getTable();

        $part = new InquiryParticipants();
        $part_t_name = $part->getTable();

        $orm_build = DB::table($msg_t_name)
            ->leftJoin($part_t_name,$msg_t_name.'.thread_id', '=', $part_t_name.'.thread_id')
            ->where($msg_t_name.'.user_id','=',$this->user_id)->where($msg_t_name.'.extends->soft_deleted_at',false)->where($part_t_name.'.extends->soft_deleted_at',false);

        $all =  clone $orm_build;
        $unread = clone $orm_build;
        $read = clone $orm_build;

        $all = $all->get()->toArray();
        $unread =$unread->where($part_t_name.'.last_read',null)->get()->toArray();
        $read = $read->where($part_t_name.'.last_read','!=',null)->get()->toArray();

        return $this->echoSuccessJson('成功!',compact('all','unread','read'));
    }

    public function inboxMessage(){
        $this->autoMarkSpamMessage();
        $orm_build = InquiryParticipants::where('user_id',$this->user_id)->where('extends->soft_deleted_at',false)->where('extends->is_spam',false); //todo 去除垃圾询盘
        $all =  clone $orm_build;
        $unread =  clone $orm_build;
        $pending_for_reply =  clone $orm_build;
        $all = $all->get()->toArray();
        $unread = $unread->where('last_read',null)->get()->toArray();
        $pending_for_reply = $pending_for_reply->where('extends->is_reply','=',false)->get()->toArray();
        return $this->echoSuccessJson('成功',compact('all','unread','pending_for_reply'));
    }

    public function spamMessage(){
        $orm_build = InquiryParticipants::where('user_id',$this->user_id)->where('extends->soft_deleted_at',false)->where('extends->is_spam',true);
        $all = $orm_build->get()->toArray();
        return $this->echoSuccessJson('成功',compact('all'));
    }

    //获取标记为旗帜的消息
    public function flagMessage(){
        $id = Auth::id();
        $outbox = InquiryMessages::where('user_id',$id)->where('extends->is_flag','=',true)->get()->toArray();
        $inbox = InquiryParticipants::where('user_id',$id)->where('extends->is_flag','=',true)->get()->toArray();
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
        $rom_build = InquiryParticipants::where('user_id',$this->user_id)->where('thread_id',$thread_id);

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

        if($type == 'inbox'){
           $participant_id_list = $request->input('participants_id_list');
            InquiryParticipants::whereIn('id',$participant_id_list)->where('user_id',$this->user_id)->get()->map(function ($item)use ($action){
                $item->forceFill(['extends->soft_deleted_at'=>$action == 'mark' ? Carbon::now()->toDateTimeString() :false]);
                $item->save();
            });
        }elseif ($type == 'outbox'){
            $messages_id_list = $request->input('messages_id_list');
            InquiryMessages::whereIn('id',$messages_id_list)->where('user_id',$this->user_id)->get()->map(function ($item)use ($action){
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

        InquiryParticipants::where('user_id',$this->user_id)->where('id',$participant_id)->update(['last_read'=>Carbon::now()->toDateTimeString()]);
        return $this->echoSuccessJson('成功!',[]);
    }

    public function autoMarkSpamMessage(){
        $thread_id_list = InquiryParticipants::where('user_id',$this->user_id)->where('extends->is_spam',true)->orderBy('thread_id')->pluck('thread_id');
        InquiryParticipants::where('user_id',$this->user_id)->whereIn('thread_id',$thread_id_list)->get()->map(function ($item){
            $item->forceFill(['extends->is_spam'=> true]);
            $item->save();
        });
    }

}
