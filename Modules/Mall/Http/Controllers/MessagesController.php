<?php

namespace Modules\Mall\Http\Controllers;

use App\Utils\EchoJson;
use App\Utils\EMail;
use Illuminate\Http\Request;
use Modules\Mall\Entities\InquiryMessages;
use Modules\Mall\Entities\InquiryParticipants;
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
        'purchase_quantity',
        'unit',
        'extra_request',
        'from_email'
    ];

    const PARTICIPANTS_EX = [

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
        $input = $request->all();
        $thread = Thread::create([
            'subject' => $input['subject'],
        ]);

        // Message
        InquiryMessages::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
            'extends'=>$input['msg_extends'],
        ]);

        // Sender
        InquiryParticipants::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
            'extends' =>$input['participants_extends'],
        ]);

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant($input['recipients']); //参与者是个数组可以有多个用户
        }

    }

    public function replyMessage(Request $request){

    }

    public function deleteMessage(Request $request){

    }

    public function emptyMessage(Request $request){

    }

    public function getIndexList(Request $request){
        $user_id = Auth::user()->id;
        $message_list = Participant::where(['user_id'=>$user_id,'deleted_at'=>null])->get()->toArray();
        return $this->echoSuccessJson('成功!',compact('message_list'));

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
