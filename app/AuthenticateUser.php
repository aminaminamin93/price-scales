<?php
namespace App;

Use App\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard as Authenticator;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Session;
use Redirect;
class AuthenticateUser{

  private $users;
  private $socialite;
  private $auth;

  public function __construct(UserRepository $users , Socialite $socialite , Authenticator $auth){
    $this->users = $users;
    $this->socialite = $socialite;
    $this->auth = $auth;
  }

  public function execute($hasCode, AuthenticateUserListener $listener, $provider){

    if(isset($_REQUEST['error'])){
      Session::flash('message', 'You have deny permission');
      return Redirect::home();
    }


    if(! $hasCode) return $this->getAuthorizationFirst($provider);

    // $user = $this->socialite->driver($provider)->user();
    // dd($user);
    // die();


    $users = $this->users->findByUsernameOrCreate($this->getGithubUser($provider));

    if($users == false){
      Session::flash('message', 'email already in used');
      return redirect('auth/login')->with('title', 'login');
    }else{
      $this->auth->login($users , true);
      return $listener->userHasLoggedIn($users);
    }

  }

  private function getAuthorizationFirst($provider){

    return $this->socialite->driver($provider)->redirect();
  }

  private function getGithubUser($provider){
  
    return $this->socialite->driver($provider)->user();
  }


}
