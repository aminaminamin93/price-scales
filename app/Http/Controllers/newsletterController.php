<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Input;
// use App\User;
use App\Newsletter;
use Carbon\carbon;

class newsletterController extends Controller
{
    public function index(){

      $data = array('email'=> 'battlefieldcompny@gmail.com', 'name'=>'mohd aminuddin ali' );
      Mail::send('email.index', ['name'=> $data['name'], 'email'=> $data['email'] ], function($message) use ($data){

          $message->to($data['email'], $data['name'])->subject('reset password');
      });
    }


    public function subscribe($email){
      $users = \DB::table('users')
        ->where('user_email', '=', $email)
        ->first();

      if(!$users){
        return array('message'=>'You not a user. Please register to continue','action'=>'register','email'=> $email);
      }else{
          //user is register but not subscribe yet

          $newletters = \DB::table('newsletter')->where('subscripe_id','=',$users->id)->first();
          if(!$newletters){
              $newletters  = \DB::table('newsletter');
              $subsciber = array('subscripe_id' => $users->id,'newsletter'=> 'any word', 'created_at'=>Carbon::now() ,'updated_at'=>Carbon::now() );

              $newletters->insert($subsciber);
              return array('message'=>'Successfully subscibe. Please login to continue','action'=>'login','email'=> $email);
          }else{
              return array('message'=>'You already subscibe. Please login to continue','action'=>'login','email'=> $email);
          }




      }

    }
}
