<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Products;
class testerController extends Controller
{

    public function searchFulltext(){
      $data = \Input::get('search');

      $products = \DB::table('products')
        // ->select('product_name','product_price','product_price_temp','shopper_link')
        ->whereRaw("MATCH(product_name) AGAINST(?)",array($data))
        // ->groupBy('product_name', 'score')
        ->orderBy('index')
        // ->setBindings([$data, $data, 1])
        ->get();

        dd($products);
        foreach ($products as $product) {


        }

    }
}
