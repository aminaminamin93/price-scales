<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class brandController extends Controller
{
    public function index(){
      $brands = \DB::table('brand')
        ->orderBy('brand_title', 'ASD')
        ->get();
        return $brands;
    }

    public function brand($id){
      $brands = \DB::table('products')
        ->join('category','products.category_id','=','category.id')
        ->join('condition','products.condition_id','=','condition.id')
        ->where('products.brand_id','=',$id)
        ->select('products.*','brand_title as title')
        ->get();
        return $brands;
    }
}
