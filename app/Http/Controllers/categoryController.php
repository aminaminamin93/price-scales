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
    public function allcategory(){
      $categories = \DB::table('products')
        ->join('category','products.category_id','=','category.id')
        ->join('condition','products.condition_id','=','condition.id')
        ->select('products.*','category_title','condition.condition_title')
        ->get();

        $newcategories = array();
        foreach ($categories as $category) {
          $compareproducts = \DB::table('products')
            ->select(\DB::raw('count(*) as counter'))
            ->where('id' , '<>', $category->id)
            ->where('brand_id', '=', $category->brand_id)
            ->where('category_id','=',$category->category_id)
            ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($category->product_name))
            ->get();
            foreach ($compareproducts as $compareproduct) {
              if($compareproduct->counter >= 1){
                $comparetable = true;
              }else{
                $comparetable = false;
              }
            }
          $newcategories[] = [ 'id'=>$category->id,
                        'product_name'=>$category->product_name,
                        'product_price'=>$category->product_price,
                        'product_price_temp'=>$category->product_price_temp,
                        'product_favorite'=>$category->product_favorite,
                        'product_reviews'=>$category->product_reviews,
                        'picture_link'=>$category->picture_link,
                        'shopper_link'=>$category->shopper_link,
                        'comparetable'=>$comparetable
                      ];
        }
        return $newcategories;
    }
    public function category(Request $request){


      if($request->get('id') == 0){
          $categories = \DB::table('products')
            ->join('category','products.category_id','=','category.id')
            ->join('condition','products.condition_id','=','condition.id')
            ->select('products.*','category_title','condition.condition_title')
            ->get();

            $newarr = array();
            foreach ($categories as $category) {
              $compareproducts = \DB::table('products')
                ->select(\DB::raw('count(*) as counter'))
                ->where('id' , '<>', $category->id)
                ->where('brand_id', '=', $category->brand_id)
                ->where('category_id','=',$category->category_id)
                ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($category->product_name))
                ->get();
                foreach ($compareproducts as $compareproduct) {
                  if($compareproduct->counter >= 1){
                    $comparetable = true;
                  }else{
                    $comparetable = false;
                  }
                }
              $newarr[] = [ 'id'=>$category->id,
                            'product_name'=>$category->product_name,
                            'product_price'=>$category->product_price,
                            'product_price_temp'=>$category->product_price_temp,
                            'product_favorite'=>$category->product_favorite,
                            'product_reviews'=>$category->product_reviews,
                            'picture_link'=>$category->picture_link,
                            'shopper_link'=>$category->shopper_link,
                            'comparetable'=>$comparetable
                          ];
            }
            return $newarr;
      }else{
        $categories = \DB::table('products')
          ->join('category','products.category_id','=','category.id')
          ->join('condition','products.condition_id','=','condition.id')
          ->where('products.category_id','=',$request->get('id'))
          ->select('products.*','category_title as title','condition.condition_title')
          ->get();
          $newarr = array();
          foreach ($categories as $category) {
            $compareproducts = \DB::table('products')
              ->select(\DB::raw('count(*) as counter'))
              ->where('id' , '<>', $category->id)
              ->where('brand_id', '=', $category->brand_id)
              ->where('category_id','=',$category->category_id)
              ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($category->product_name))
              ->get();
              foreach ($compareproducts as $compareproduct) {
                if($compareproduct->counter >= 1){
                  $comparetable = true;
                }else{
                  $comparetable = false;
                }
              }
            $newarr[] = [ 'id'=>$category->id,
                          'product_name'=>$category->product_name,
                          'product_price'=>$category->product_price,
                          'product_price_temp'=>$category->product_price_temp,
                          'product_favorite'=>$category->product_favorite,
                          'product_reviews'=>$category->product_reviews,
                          'picture_link'=>$category->picture_link,
                          'shopper_link'=>$category->shopper_link,
                          'comparetable'=>$comparetable
                        ];
          }
          return $newarr;
      }

    }
}
