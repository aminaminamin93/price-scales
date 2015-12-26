<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Retailer;
use Input;
use Session;


class SendmailController extends Controller
{
    //sending email to any retailers
    public function emailToRetailer($id){
        $retailer = Retailer::find($id);
        $input = Input::all();

        if(Retailer::find($id)){

            $email_id = $retailer->retailer_email;
            $message = $input['message'];

            $data = array('email'=> $email_id, 'name'=>'Online Price Comparison', 'subject'=>$input['subject'] );
            if(Mail::send( 'email.sendToRetailer' , ['name'=> $data['name'] , 'email'=> $data['email'] ], function($message) use ($data){

                $message->to($data['email'], $data['name'])->subject($data['subject']);
            })){
                Session::flash('sendingmail-notification', 'Your email successfully sent');

                return \View::make('/admin/retailer/message')
                    ->with('retailer', $retailer)
                    ->with('title', 'Message');
            }else{

            }

        }else{

        }

    }

}
