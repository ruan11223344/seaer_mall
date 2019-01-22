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

    public function __construct()
    {
        //todo 消息滥用禁止发送 规则 每天超过100封
    }

    public function __destruct()
    {
        if($this->function_name == 'createMessage' || $this->function_name == 'replyMessage'){
            foreach ($this->mail_notification as $user_id){
                if(UsersExtends::where(['user_id'=>$user_id,'email_notification'=>true])->get() !== null){
                    $this->sendMailNotification($user_id);
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

    public function sendMailNotification($user_id){

    }

    public function createMessage(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'to_af_id'=>'exists:users_extends,af_id',
            'reply_to_email'=>'email|nullable'
        ]);

        if ($validator->fails()) {
            return $this->echoErrorJson('表单验证失败!'.$validator->messages());
        }

        $reply_to_email = $request->input('reply_to_email',null) == null ? Auth::user()->email :  $request->input('reply_to_email');

        $attachments = UtilsController::uploadMultipleFile($request->file('attachment_list'),UtilsController::getUserAttachmentDirectory());
        try{
            DB::beginTransaction();
            $thread = InquiryThreads::create([
                'subject' => $request->input('subject'),
                'extends'=>[
                    'reply_to_email'=>$reply_to_email,
                    'extra_request'=>$request->input('extra_request',null),
                    'purchase_quantity'=>$request->input('purchase_quantity',null),
                    'purchase_unit'=>$request->input('purchase_unit',null),
                    'attachment_list'=>$attachments,
                ],
            ]);
            // Message
            InquiryMessages::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => $request->input('content'),
            ]);
            // Sender
            $to_user_id = UsersExtends::where('af_id',$request->input('to_af_id'))->first()->user_id;

            InquiryParticipants::create([
                'thread_id' => $thread->id,
                'user_id' => $to_user_id,
                'last_read' => null,
                'extends'=>[],
            ]);

            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            return $this->echoErrorJson('发布消息失败!',[$e->getMessage()]);
        }
        return $this->echoSuccessJson('发布消息成功',$thread->toArray());
    }

    public function replyMessage(Request $request){

    }

    public function deleteMessage(Request $request){

    }

    public function emptyMessage(Request $request){

    }

    public function getIndexList(Request $request){
        $user = Auth::user();
        $user_model = User::find($user->id);
        $s = $user_model->messages;

        $all = $message_list->get();
        $unread = $message_list->where('last_read',null)->get();
        $read = $message_list->where('last_read','!=',null)->get();

        return $this->echoSuccessJson('成功!',compact('all','unread','read'));
    }

    public function getSpamList(Request $request){

    }



    public function index()
    {
        // All threads, ignore deleted/archived participants
        $threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        // $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('messenger.index', compact('threads'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('messages');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::id();
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $thread->markAsRead($userId);

        return view('messenger.show', compact('thread', 'users'));
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('messenger.create', compact('users'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store()
    {
        $input = Input::all();

        $thread = Thread::create([
            'subject' => $input['subject'],
        ]);

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
        ]);

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant($input['recipients']);
        }

        return redirect()->route('messages');
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('messages');
        }

        $thread->activateAllParticipants();

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => Input::get('message'),
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = new Carbon;
        $participant->save();

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant(Input::get('recipients'));
        }
        return redirect()->route('messages.show', $id);
    }
}
