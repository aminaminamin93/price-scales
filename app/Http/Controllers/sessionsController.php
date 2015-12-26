<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use Input;
use App\User;
use App\Products;
use Redirect;
use Session;
use Carbon\carbon;
class sessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('auth/login')->with('title', 'Login');
    }
    public function login_newsletter($email)
    {
        Session::flash('email',$email);
        return Redirect::to('auth/login')
          ->with('title', 'Login');
    }
    public function register(){
        return View::make('auth/register')->with('title', 'Registration');
    }

    public function login(){


        $user = new User;
        $user->user_firstname = Input::get('firstname');
        $user->user_lastname = Input::get('lastname');
        $user->user_email = Input::get('email');
        $user->password = bcrypt(Input::get('password'));
        $user->provider_id = mt_rand(10000000, 99999999);
        $user->role_id = 3;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        if($user){
            $attempt = \Auth::attempt([
                'user_email' => $input['email'],
                'password' => $input['password']
            ]);
            if ($attempt) return \Redirect::intended('/home');
            else {
                return \Redirect::to('auth/login')->withInput(Input::except('password'))
                    ->with('alert-danger', 'Your email or password not valid.');
            }
        }else{
             return \Redirect::to('auth/login')->withInput(Input::except('password'))
                    ->with('alert-danger', 'Your email or password not valid.');
        }
        //
        // return View::make('auth/register')->with('title', 'Registration');
    }

    public function reset(){
        return View::make('auth/reset')->with('title', 'Forgot Password');
    }



    public function create(){

        $input = Input::all();
        $rules = array(
            'firstname' => 'required|min:5|max:100',
            'lastname' => 'required|min:2|max:100',
            'user_email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|confirmed',
            'password_confirmation' => 'required|alpha_num',

        );
        $validator = \Validator::make($input, $rules);
            if ($validator->fails())
                //redirect to registration page with errors return
                 return \Redirect::to('auth/register')->withInput(Input::except('password'))->withErrors($validator);
            else{
                //store the new user


                    $data = array('firstname' => $input['firstname'] ,'lastname' => $input['lastname'] ,'email' => $input['user_email'],'password'=>$input['password']);
                    $email =  Mail::send('email.confirmation-user', ['firstname' => $data['firstname'],'lastname' => $data['lastname'], 'email' => $data['email'], 'password'=>$data['password']], function ($message) use ($data) {

                        $message->to($data['email'], $data['password'])->subject('Confirm your account');
                    });

                    $mailserver = explode('@',$input['user_email']);

                   if($email){
                        Session::flash('email_confirmation', 'Confirmation email has been sent to your email address '.$input['user_email']);
                       return \View::make('auth/login')->with('mailserver', $mailserver[1])->with('title', 'Login');
                   }


            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //store and login session after user login...
    public function store()
    {
        $input = Input::all();
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:5',
        );

        $validator = \Validator::make($input, $rules);
        if ($validator->fails()) {
            return \Redirect::to('auth/login')->withInput(Input::except('password'))->withErrors($validator);
        }else{
            $attempt = \Auth::attempt([
                'user_email' => $input['email'],
                'password' => $input['password']
            ]);

            if ($attempt) {
                $products = Products::all();

                return \Redirect::intended('/home')->with('products', $products);
            }else {

                return \Redirect::to('auth/login')->withInput(Input::except('password'))
                    ->with('alert-danger', 'Your email or password not valid.')
                    ->withErrors($validator);
            }
        }
    }





    //sending link to reset password to user email.....
    public function email(){
        $input = Input::all();
        $rules = array(
            'email' => 'required|email',
        );
        $validator = \Validator::make($input, $rules);
        if ($validator->fails()) {
            return \Redirect::to('auth/reset')->withInput()->withErrors($validator);
        }else{

            if($user = User::where('user_email',$input['email'])->first()){

              $data = array('email'=> $input['email'], 'name'=>'mohd aminuddin ali','provider_id'=> $user->provider_id );
              Mail::send('email.reset_password', ['name'=> $data['name'], 'email'=> $data['email'], 'provider_id'=>$data['provider_id'] ], function($message) use ($data){

                  $message->to($data['email'], $data['name'])->subject('reset password');
              });
              return \Redirect::to('auth/login')->with('title', 'Login');
            }

            Session::flash('alert-danger','This email is not register yet');
            return \Redirect::to('auth/reset')->withInput()->withErrors($validator);

        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function recoverPassword($provider){
        $users = User::where('provider_id', $provider)->first();

        return View::make('auth/password_recovery')
            ->with('users', $users)
            ->with('title', 'Reset Password');
    }

    public function recover()
    {
      $input = Input::all();
      $rules = array(
        'user_email' => 'required|email',
        'password' => 'required|alpha_num|confirmed',
        'password_confirmation' => 'required|alpha_num',
      );
      $validator = \Validator::make($input, $rules);
      if ($validator->fails()) {
          return \Redirect::to('auth/recover_password')->withInput()->withErrors($validator);
      }else{
          if(User::where('user_email',$input['user_email'])->first()){

            Session::flash('alert-success','Your password has been updated,try to login');
            return \Redirect::to('auth/login')->with('title','Login');
          }else{

            Session::flash('alert-danger','Your password not updated,Please check your email');
            return \Redirect::to('auth/recover_password')->with('title','Reset Password');
          }

      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $users = User::find(\Auth::user()->id);
        $users->last_login = Carbon::now('Asia/Kuala_Lumpur');
        $users->save();

        \Auth::logout();
        \Session::flash('message', 'You are now logout');
          // return View::make('auth/login')->with('title', 'login');
        return redirect('auth/login')->with('title', 'login');
    }
}
