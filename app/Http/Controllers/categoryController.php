<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class categoryController extends Controller
{
    public function index(){
      $categories = \DB::table('category')
        ->get();
        return $categories;
    }
    public function category($id){


      if($id == 0){
        // $categories = \DB::table('products')
          // ->join('category','products.category_id','=','category.id')
          // ->select('products.*','category_title as title')
          // ->get();
          $categories = \DB::table('products')
            ->join('category','products.category_id','=','category.id')
            ->join('condition','products.condition_id','=','condition.id')
            ->select('products.*','category_title','condition.condition_title')
            ->get();
            return $categories;
      }else{
        $categories = \DB::table('products')
          ->join('category','products.category_id','=','category.id')
          ->join('condition','products.condition_id','=','condition.id')
          ->where('products.category_id','=',$id)
          ->select('products.*','category_title as title','condition.condition_title')
          ->get();
        return $categories;
      }

    }
}
