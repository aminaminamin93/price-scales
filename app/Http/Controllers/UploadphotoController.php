<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Validator;

class UploadphotoController extends Controller
{
    public function upload(){


        $file = $file = array('image' => Input::file('image'));

        $rules = array(
            'image' => 'image|mimes:jpg,jpeg,gif,png',
        );

        $validator = \Validator::make($file, $rules);

        if($validator->fails()){
            die("validate fail");
        }else{
            if (Input::file('image')->isValid()) {


                $destinationPath = base_path().'/public/admin-bootstrap/img/retailers/';
                $extension = Input::file('image')->getClientOriginalExtension();


                $fileName = rand(11111,99999).'.'.$extension;

                $upload = Input::file('image')->move($destinationPath, $fileName);

                echo   $destinationPath.$fileName;
                if($upload){die('successfully upload');}else{die('fail uploaded');}

            }
        }
    }
}
