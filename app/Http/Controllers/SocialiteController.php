<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AuthenticateUser;
use App\AuthenticateUserListener;
use App\Products;
use App\User;

class SocialiteController extends Controller implements AuthenticateUserListener
{

  	public function login($provider, AuthenticateUser $authenticateUser, Request $request){

      return $authenticateUser->execute($request->has('code'), $this, $provider);
    }

    public function userHasLoggedIn($user){
        $products = Products::all();
        $user = User::all();
        return redirect('/')
        	->with('title', 'Home')
        	->with('products', $products)
        	->with('users', $user);
    }


}
