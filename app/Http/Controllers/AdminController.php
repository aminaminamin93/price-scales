<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Session;
use App\Crawler;
use App\Pdf;
use App\PriceList;
use App\Website;
use App\User;
use Carbon\Carbon;
use View;
use DB;

class AdminController extends Controller
{

    public function index(){

            return View::make('admin/login');
    }   

    public function admin(){
        Session::flash('welcome-notification', 'Welcome to admin panel');
        return View::make('admin/panel')->with('title', 'Admin Panel');
    }

    public function getLogin(){

        $input = Input::all();
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:5',
        );

        $validator = \Validator::make($input, $rules);
        if ($validator->fails()) {
            return \Redirect::to('admin/login')->withInput(Input::except('password'))->withErrors($validator);
        }else{
            $attempt = \Auth::attempt([
                'user_email' => $input['email'],
                'password' => $input['password']
            ]);

            if ($attempt) {

                return \Redirect::intended('/admin');
            }else {

                return \Redirect::to('login/admin')->withInput(Input::except('password'))
                    ->with('alert-success', 'Your email or password not valid.')
                    ->withErrors($validator);
            }
        }
        return \Redirect::to('admin');
    }

    public function logsSetting(){
        return \View::make('/admin/settings/logsSetting')
            ->with('title', 'Logs & Settings');
    }
    
    public function generalSettings(){
      $user_id = \Auth::user()->id;
      $users = \DB::table('role')
        ->join('users', 'role.id' , '=', 'users.role_id')
        ->where('users.id' , '=', $user_id)
        ->get();
      
      return $users;
      // return "ajax reach";
    }

    public function profile($id){
        $user = User::find($id);

        return View::make('admin/profile/general')
            ->with('users', $user)
            ->with('title', 'Profile');
    }

    public function crawler(Request $request){

            $pdfs = Pdf::all();
            // $pricelists = Pdf::all();
            $result = "<div class='crawler_list'><div class='row'>";


            $result = $result."<h4>PDF</h4><ul class='list-crawler'>";
            foreach ($pdfs as $pdf) {
              $result = $result."<li>";
              $retailers = \DB::table('retailers')->where('id', '=', $pdf->retailer_id )->get();

              foreach ($retailers as $retailer) {
                $result = $result. $retailer->retailer_name;
              }

              $result = $result. $pdf->crawler->id;
              $result = $result."</li>";
            }
            $result = $result."</ul></div><div class='row'>";
            $websites = Website::all();
            // $pricelists = Pdf::all();
            $result = $result."<button type='button' class='btn btn-xs' id='progress'>Progress</button>". "<h4>WEBSITE</h4>";
            foreach ($websites as $website) {
              // $retailers = \DB::table('retailers')->where('id', '=', $pdf->pricelist->retailer_id )->get();
              // foreach ($retailers as $retailer) {
              //   $result = $result. $retailer->retailer_name;
              // }
              $result = $result. $website->crawler->id;

            }
            $result = $result."</div></div>";
            return $result;
            // foreach ($pricelists as $pricelist) {
            //
            // }
    }

    public function save(Request $request)
    {
        
        if( $request->isXmlHttpRequest())
        {
            if($request->get('data')){
                return $request->get('data');
            }else{
                return "fdsfsdfd";
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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

        return \Redirect::to('admin/login')
            ->with('title', 'Login');
    }

    public function systemlogs(){
        $users = DB::table('users')
            ->join('role', 'users.role_id', '=', 'role.id')
            ->select('users.*', 'role.role_title')
            ->get();

        return $users;
    }
}
