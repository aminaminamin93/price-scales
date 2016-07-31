<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class brandController extends Controller
{
    public function index(){
      $brands = \DB::table('brand')
        ->orderBy('brand_title', 'DESC')
        ->get();
        return $brands;
    }
    public function allbrand(){
      $brands = \DB::table('products')
        ->join('brand','products.category_id','=','brand.id')
        ->join('condition','products.condition_id','=','condition.id')
        ->select('products.*','brand_title','condition.condition_title')
        ->get();
        $newbrands = array();
        foreach ($brands as $brand) {
          $compareproducts = \DB::table('products')
            ->select(\DB::raw('count(*) as counter'))
            ->where('id' , '<>', $brand->id)
            ->where('brand_id', '=', $brand->brand_id)
            ->where('category_id','=',$brand->category_id)
            ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($brand->product_name))
            ->get();
            foreach ($compareproducts as $compareproduct) {
              if($compareproduct->counter >= 1){
                $comparetable = true;
              }else{
                $comparetable = false;
              }
            }
          $newbrands[] = [ 'id'=>$brand->id,
                        'product_name'=>$brand->product_name,
                        'product_price'=>$brand->product_price,
                        'product_price_temp'=>$brand->product_price_temp,
                        'product_favorite'=>$brand->product_favorite,
                        'product_reviews'=>$brand->product_reviews,
                        'picture_link'=>$brand->picture_link,
                        'shopper_link'=>$brand->shopper_link,
                        'comparetable'=>$comparetable
                      ];
        }
        return $newbrands;
    }
    public function brand(Request $request){
      if($request->get('id') == 0){
        $brands = \DB::table('products')
          ->join('brand','products.category_id','=','brand.id')
          ->join('condition','products.condition_id','=','condition.id')
          ->select('products.*','brand_title','condition.condition_title')
          ->get();
          $newarr = array();
          foreach ($brands as $brand) {
            $compareproducts = \DB::table('products')
              ->select(\DB::raw('count(*) as counter'))
              ->where('id' , '<>', $brand->id)
              ->where('brand_id', '=', $brand->brand_id)
              ->where('category_id','=',$brand->category_id)
              ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($brand->product_name))
              ->get();
              foreach ($compareproducts as $compareproduct) {
                if($compareproduct->counter >= 1){
                  $comparetable = true;
                }else{
                  $comparetable = false;
                }
              }
            $newarr[] = [ 'id'=>$brand->id,
                          'product_name'=>$brand->product_name,
                          'product_price'=>$brand->product_price,
                          'product_price_temp'=>$brand->product_price_temp,
                          'product_favorite'=>$brand->product_favorite,
                          'product_reviews'=>$brand->product_reviews,
                          'picture_link'=>$brand->picture_link,
                          'shopper_link'=>$brand->shopper_link,
                          'comparetable'=>$comparetable
                        ];
          }
      }else{
          $brands = \DB::table('products')
            ->join('category','products.category_id','=','category.id')
            ->join('condition','products.condition_id','=','condition.id')
            ->join('brand','products.brand_id','=','brand.id')
            ->where('products.brand_id','=',$request->get('id'))
            ->select('products.*','brand.brand_title as title')
            ->get();
            $newarr = array();
            foreach ($brands as $brand) {
              $compareproducts = \DB::table('products')
                ->select(\DB::raw('count(*) as counter'))
                ->where('id' , '<>', $brand->id)
                ->where('brand_id', '=', $brand->brand_id)
                ->where('category_id','=',$brand->category_id)
                ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($brand->product_name))
                ->get();
                foreach ($compareproducts as $compareproduct) {
                  if($compareproduct->counter >= 1){
                    $comparetable = true;
                  }else{
                    $comparetable = false;
                  }
                }
              $newarr[] = [ 'id'=>$brand->id,
                            'product_name'=>$brand->product_name,
                            'product_price'=>$brand->product_price,
                            'product_price_temp'=>$brand->product_price_temp,
                            'product_favorite'=>$brand->product_favorite,
                            'product_reviews'=>$brand->product_reviews,
                            'picture_link'=>$brand->picture_link,
                            'shopper_link'=>$brand->shopper_link,
                            'comparetable'=>$comparetable
                          ];
            }
        }
        return $newarr;
    }
}
