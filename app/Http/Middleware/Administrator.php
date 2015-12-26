<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use Redirect;
class Administrator
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next )
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/admin/login');
            }

        }else{
            //role id  == 1 is an admin else 2 is not an admin
           if(($this->auth->user()->role_id == 1) || ($this->auth->user()->role_id == 2) ){

           }else{
               if(\Route::get('/admin'))
                    return redirect()->guest('login/admin');
               else
                    return redirect()->guest('auth/login');
           }
        }

        return $next($request);
    }
}
