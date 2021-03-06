<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\Users;
use DB;

class messageController extends Controller
{
    public function index(){
      // $ranges = explode(',',\Input::get('view'));
      $row = \Input::get('view');
      $mails = DB::table('messages')
        ->join('users', 'messages.user_id' , '=', 'users.id')
        ->select(
            array('messages.id as message_id',
                  'messages.message_title',
                  'messages.message_content',
                  'messages.message_status',
                  'messages.created_at as message_created_date',
                  'messages.updated_at as message_updated_date',
                  DB::raw('COUNT(messages.id) as message_total' ), 'users.*')
                  )
        ->groupBy('messages.id')->skip($row)
        ->take(2)
        ->get();

      return $mails;
    }

    public function totalMessage(){
      $mails = DB::table('messages')
        ->select(DB::raw('COUNT(id) as total'))
        ->get();
      return $mails;
    }

    public function contactUs(Request $request){
      $request->get('subject');

      $users = DB::table('users')
        ->where('user_email','=',$request->get('email'))
        ->first();

      if($users){
          return array('alert_type'=>'alert-success', 'alert_message'=>'Your message have been sent', 'action'=>'login');
      }else{
          return array('alert_type'=>'alert-danger', 'alert_message'=>'Your email not register with Us.', 'action'=>'register');
      }



    }
}
