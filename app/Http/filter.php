<?php
    App::before(function($request) {

    });

    App::after(function($request, $response){

    });



Route::filter('auth', function(){
   if(Auth::guest())return Redirect::guest('login');
});

Route::filter('auth.basic', function() {
    return Auth::basic();
});