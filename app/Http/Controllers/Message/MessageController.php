<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public function index(){
     
       //select users 
       
       $me = $this->user->id;
       $users_to = $this->user->message()->distinct()->get('to');
       //$users = Message::find(2)->user;
       $users_from = $this->user->message_to()->distinct()->get('from');
       $users = User::whereIn('id', $users_to)->orWhereIn('id', $users_from)->get();

       //count how many message are unread from the selected users

       $unread_message = $this->user->message_to()->select(DB::raw('count(is_read) as unread'), 'from')
       ->where('is_read', '=', 0)->groupBy('from')->get();

       return response()->json(["users" => $users, "unread" => $unread_message]);
    }

    public function getMessage($user_id){
        $me = $this->user->id;
        // when click to see message selected user's message will be read, update
        Message::where(['from' =>$user_id, 'to' => $me])->update(['is_read' => 1]);
        
        //getting all message for selected user
        //getting those message which is from me to user_ide or contraire
        $message = Message::where(function($query) use ($user_id, $me){
            $query->where('from', $me)->where('to', $user_id);
        })->orWhere(function($query) use ($user_id, $me){
            $query->where('from', $user_id)->where('to', $me);
        })->get();
        //$message = $this->user->message()->get(['id', 'from', 'to', 'created_at', 'message', 'is_read']);
       return response()->json(["message" => $message]);
    }
    protected function guard(){
        return Auth::guard();
    }

    public function postMessage(Request $request){

        $from = $this->user->id;
        $to = $request->user_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();
        return response()->json(["message" => "success"]);
    }

    public function deleteMessage(Message $message){

        //$me = $this->user->id;
       // Message::where(['from' => $me, 'to' => $user_id, 'id' => $request->id])->delete();
       $response = $message->delete() ?  response()->json(['status' => true, 'message' => $message], 201) : response()->json(['status' => false, 'message' => 'Oops, the message could not be deleted']);
        return $response;
       
    }
}