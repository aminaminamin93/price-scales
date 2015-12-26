<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Retailer;
use Input;
use Session;
use View;
class RetailerController extends Controller
{



    public function create(){
        $input = Input::all();

        $rules = array(
            'retailer_name' => 'required|min:5',
            'retailer_email' => 'required|email',
            'retailer_site' => 'required|url',
            'retailer_description' => 'required|min:10',
            'retailer_image' => 'image|mimes:jpg,png,jpeg,gif',
        );


        $validator = \Validator::make($input, $rules);
        if (!$validator->fails()) {

            //upload image here

            if (Input::file('retailer_image')->isValid()) {


                $destinationPath = base_path() . '/public/admin-bootstrap/img/retailers/';
                $extension = Input::file('retailer_image')->getClientOriginalExtension();


                $fileName = rand(1111111111, 9999999999) . '.' . $extension;

                $upload = Input::file('retailer_image')->move($destinationPath, $fileName);


                $retailer = new Retailer;

                $retailer->retailer_name = $input['retailer_name'];
                $retailer->retailer_email = $input['retailer_email'];
                $retailer->retailer_site = $input['retailer_site'];
                $retailer->retailer_description = $input['retailer_description'];
                $retailer->picture_link = $fileName;
//                $retailer->created_at = new \DateTime->
                $retailer->save();

        }









                if ($retailer) {
                    Session::flash('register-retailer', 'successfully register new retailer');
                    Session::flash('alert-type', 'alert-success');
                } else {
                    Session::flash('register-retailer', 'fail to register new retailer');
                    Session::flash('alert-type', 'alert-danger');
                }


                $retailers = Retailer::all();
                return \Redirect::to('/retailer/view')
                    ->with('retailers', $retailers)
                    ->with('title', 'Retailers');



            } else {
                $retailers = Retailer::all();
                return \Redirect::to('/retailer/view')->withInput()
                    ->withErrors($validator)
                    ->with('retailers', $retailers)
                    ->with('title', 'Retailers');




            }
    }

    public function store(Request $request){
        //
    }


    public function view(){
        $retailers = Retailer::all();
        
        return View::make('admin/retailer/retailer')
            ->with('retailers', $retailers)
            ->with('title', 'Retailers');
    }

    public function viewByid($id){
        $retailer = Retailer::find($id);

        return View::make('admin/retailer/viewOneRetailer')
            ->with('retailer', $retailer)
            ->with('title', 'Retailer');
    }

    public function contact($id){
        $retailer = Retailer::find($id);

        return View::make('admin/retailer/message')
            ->with('retailer', $retailer)
            ->with('title', 'Message');
    }


    public function update($id){

        $retailer = Retailer::find($id);
        $input = Input::all();




            $rules = array(
                'retailer_name' => 'required|min:5',
                'retailer_email' => 'required|email',
                'retailer_site' => 'required|url',
                'retailer_description' => 'required|min:10',
                'file'=>'image|mimes:jpg,jpeg,gif,png',
            );



        $validator = \Validator::make($input, $rules);

        if( $validator->fails()){
            return \Redirect::to('retailer/edit/'.$retailer->id)
                ->withErrors($validator)
                ->withInput()
                ->with('title', 'Edit Retailer');

        }else{

//            $file = $file = array('image' => Input::file('image'));

//            $rules = array(
//                'image' => 'image|mimes:jpg,jpeg,gif,png',
//            );

//            $valideImage = \Validator::make($file, $rules);
//
//            if($valideImage->fails()){
//                die("validate fail");
//            }else{
                if (Input::file('file')->isValid()) {


                    $destinationPath = base_path().'/public/admin-bootstrap/img/retailers/';
                    $extension = Input::file('file')->getClientOriginalExtension();


                    $fileName = rand(1111111111,9999999999).'.'.$extension;

                    $upload = Input::file('file')->move($destinationPath, $fileName);



//                }


            }



            $retailer->retailer_name = $input['retailer_name'];
            $retailer->retailer_email = $input['retailer_email'];
            $retailer->retailer_site = $input['retailer_site'];
            $retailer->retailer_description = $input['retailer_description'];
            $retailer->picture_link = $fileName;

        }



        if($retailer->save()){
            return "upadated";
//            Session::flash('update-retailer',);
        }else{
            return "failed";
//            Session::flash('update-retailer',)
        }


    }

    public function edit($id){
        $retailer = Retailer::find($id);

        return View::make('admin/retailer/edit_retailer')
            ->with('retailer', $retailer)
            ->with('title', 'Edit Retailer');
    }
  
    public function destroy($id) {

        $retailer = Retailer::find($id);

        $retailer->delete();
        if($retailer){
            $retailers = Retailer::all();

            Session::flash('register-retailer', 'Successfully delete the retailer');
            Session::flash('alert-type', 'alert-success');

            return \Redirect::to('/retailer/view')
                ->with('deleted-retailer', $retailer)
                ->with('retailers', $retailers)
                ->with('title', 'Retailers');
        }
    }


    public function sendEmail($id){
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
