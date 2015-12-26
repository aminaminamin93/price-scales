<?php namespace App\Repositories;
use Session;
use Redirect;
use  App\User;
class UserRepository {
  public function findByUsernameOrCreate($userData){


      $users = User::where('user_email', '=', $userData->email)->first();

      if(!$users){
        //email not used
        if($userData->nickname == null){
        $user = User::Create([
          'user_firstname' => $userData->name,
          'user_email' => $userData->email,
          'avatar' => $userData->avatar,
          'role_id'=> 3,
          'provider_id' => $userData->id
          ]);
        }else{
          $user = User::Create([
            'user_firstname' => $userData->nickname,
            'user_email' => $userData->email,
            'avatar' => $userData->avatar,
            'role_id'=> 3,
            'provider_id' => $userData->id
            ]);
        }
        return $user;
      }else{
        $users = User::where('user_email', '=', $userData->email)->where('provider_id', '=', $userData->id)->first();
        if($users){
          //email used with same provider id
          return $users;
        }else{
          //email is used with different provider id
          //cannot sign up with same email because different provider id(email cannot be duplicate user)
          $user = false;
          return $user;
        }
      }



  }
}
