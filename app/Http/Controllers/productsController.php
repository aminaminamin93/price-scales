<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Products;
use App\Retailer;
use App\User;
use View;
use App\Enroll;
use Input;
class productsController extends Controller
{

    public function index(){
        $products = Products::all();
        return View::make('product/view')->with('products', $products);
    }
    public function home(){
        $products = Products::all();
        $user = User::all();

        return View::make('home/index')->with('title', 'Home')
            ->with('products', $products)
            ->with('users', $user);
    }

    public function details($id){
      $products = \DB::table('products')
          ->join('category', 'products.category_id','=','category.id')
          ->join('brand', 'products.brand_id','=','brand.id')
          ->join('condition', 'products.condition_id','=','condition.id')
          ->select('products.*', 'category_title','brand_title','condition_title')
          ->where('products.id','=',$id)
          ->first();

      return View::make('product/details')
          ->with('products', $products)
          ->with('title','Product details');
    }

    //related product refer to product id
    public function related($id){
      $products = Products::where('id',$id)->first();

      $relateds = \DB::table('products')
        ->whereRaw("MATCH(product_name) AGAINST(? IN BOOLEAN MODE)",array($products->product_name))
        ->where('brand_id','=', $products->brand_id)
        ->where('category_id','=', $products->category_id)
        ->where('id','<>', $products->id)
        ->take(4)
        ->get();

      return $relateds;
    }
    public function relatedCompare($id){
      $products = Products::where('id',$id)->first();

      $relateds = \DB::table('products')
        ->join('condition','products.condition_id','=','condition.id')
        ->join('brand','products.brand_id','=','brand.id')
        ->join('category','products.category_id','=','category.id')
        ->whereRaw("MATCH(products.product_name) AGAINST(? IN BOOLEAN MODE)",array($products->product_name))
        ->where('products.brand_id','=', $products->brand_id)
        ->where('products.category_id','=', $products->category_id)
        ->where('products.id','<>', $products->id)
        ->select('products.*','condition.condition_title','brand.brand_title','category.category_title')
        ->get();

      return $relateds;
    }

    //top product refer to product id
    public function top($id){
      $products = Products::where('id', $id)->first();

      $top = \DB::table('products')
        // ->where('brand_id','=', $products->brand_id)
        ->where('category_id','=', $products->category_id)
        ->where('id','<>', $products->id)
        ->orderBy('product_price', 'DESC')
        ->take(4)
        ->get();
      return $top;
    }

    //products widget area
    public function topViewed(){
      return \DB::table('products')
        ->join('condition', 'products.condition_id','=','condition.id')
        ->orderBy('products.product_reviews', 'ASD')
        ->select('products.*','condition.condition_title as condition')
        ->take(4)
        ->get();
    }
    public function recentlyViewed(){
      return \DB::table('products')
        ->join('condition', 'products.condition_id','=','condition.id')
        ->orderBy('products.product_favorite', 'ASD')
        ->select('products.*','condition.condition_title as condition')
        ->take(4)
        ->get();
    }
    public function newAdded(){
      return \DB::table('products')
        ->join('condition', 'products.condition_id','=','condition.id')
        ->orderBy('products.created_at', 'ASD')
        ->select('products.*','condition.condition_title as condition')
        ->take(4)
        ->get();
    }
    public function products($query){
      $products = \DB::table('products')
          ->join('condition','products.condition_id','=','condition.id')
          ->join('brand','products.brand_id','=','brand.id')
          ->join('category','products.category_id','=','category.id')
          ->whereRaw("MATCH(products.product_name) AGAINST(? IN BOOLEAN MODE)",array($query))
          ->select('products.*','condition.condition_title','brand.brand_title','category.category_title')
          ->get();

      return $products;
    }

    public function view_comparison($id){

        $product = Products::where('id', $id)->first();

        $products = \DB::table('products')
          ->join('enrollment', 'products.id','=','enrollment.product_id')
          ->join('retailers','enrollment.retailer_id','=','retailers.id')
          ->join('category','products.category_id','=','category.id')
          ->join('condition','products.condition_id','=','condition.id')
          ->join('brand','products.brand_id','=','brand.id')
          // ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)',array($product->product_name))
          ->where('products.id','<>',$product->id)
          ->where('brand_id', '=', $product->brand_id)
          ->where('category_id','=', $product->category_id)
          ->select( 'products.*',
                    'retailers.retailer_name','retailers.retailer_site','retailers.picture_link',
                    'category.category_title','brand.brand_title','condition.condition_title'
                  )
          ->get();

          // dd($products);
        // $other_product = Products::where('category_id', $product->category_id)
        //     ->where('id', '!=' , $product->id )
        //     ->where('brand_id', '=', $product->brand_id)
        //     ->orderBy('product_price', 'product_rating', 'ASD')
        //     ->get();

//
//        $product = \DB::table('products')
//            ->select('products.id','products.product_name','products.product_price','products.product_brand','products.product_rating','products.product_reviews','products.picture_link','products.shopper_link','products.category_id', 'retailers.picture_link as retailer_picture' )
//            ->join('enrollment', 'products.id', '=', 'enrollment.product_id')
//            ->join('retailers', 'enrollment.retailer_id', '=', 'retailers.id')
//            ->where('id', '!=' , $product->id )
//            ->where('products.product_brand', 'LIKE', $product->product_brand)
//            ->where('products.category_id', '=', $product->category_id)
//
//
//            ->orderBy('product_price', 'product_rating', 'ASD')
//            ->get();

        $star_number = 3.5;
        $floor = floor($star_number);

        //for full blank count
        $blank_star = (5 - $floor );
       //for half star count
        if(is_float($star_number)) {
            $half_star = 1;
            $full_star = $floor - 1;
        }else {
            $half_star = 0;
            $full_star = $floor;
        }
        // dd($products);
        return \View::make('product/compareProduct')
            ->with('title', $product->product_name)
            ->with('products', $product)
            ->with('compareProducts', $products)
            ->with('fullstar', $full_star)
            ->with('halfstar', $half_star)
            ->with('blankstar', $blank_star);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $products = Products::all();
        return \View::make('/product/viewall')
            ->with('products', $products)
            ->with('title', 'Products');
    }

    public function viewProduct($id){
        $product = Products::find($id);
        return \View::make('/product/viewone')
            ->with('product' , $product)
            ->with('title', 'Product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
    public function searchByForm(){
      $searchText = Input::get('searchText');
      $brand = Input::get('brand');
      $category = Input::get('category');
      $condition = Input::get('condition');
      $priceLow = Input::get('priceLow');
      $priceHigh = Input::get('priceHigh');

      $products = \DB::table('products')
        ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($searchText))
        ->where('brand_id','=',$brand)
        ->where('category_id','=',$category)
        ->where('condition_id','=',$condition)
        ->whereBetween('product_price',[$priceLow,$priceHigh])
        ->get();


      return $products;
      // return \DB::table('products')->where('brand_id','=',Input::get('brand'))->get();
    }
    public function search(Request $request){
        $search = $request['search'];
        $brand = strtolower($request['brand']);
        $category = $request['category'];
        $price =  explode(';',$request['price']);
        //$more_than = $request['more_than'];
        $condition = $request['condition'];
        $price_min = $price[0];
        $price_max = $price[1];


                $products = \DB::table('products')
//                ->where('product_name', 'LIKE', '%'.$search.'%')
//                ->where('product_name', 'LIKE', '%'.$search.'%')
//                ->get();

                ->where(function($query) use ($category, $brand) {
                  $category == 0 ? $query->where('category_id', '<>', $category) : $query->where('category_id','=', $category);
                    $brand == 0 ? $query->where('brand_id', 'NOT LIKE', '%'.$brand.'%') : $query->where('brand_id','=', $brand);
//                    if($category == 0) {
//                        $query->where('category_id', '<>', $category);
//                    }else{
//                        $query->where('category_id','=', $category);
//                    }


                })
                ->paginate(12);

        $search_data = "";

        $search == "" ? $search_data = "null_".$brand."_".$category."_".$price_min."_".$price_max."_".$condition : $search_data = $search."_".$brand."_".$category."_".$price_min."_".$price_max."_".$condition;


        $result = "";
        if(!$products){
            $result = "<div class='row'><h3>Product Not Found</h3></div>";
        }else {
            foreach (array_chunk($products->all(), 4) as $row) {
                $result = $result ."<div class='row' align='center' style='margin-top:50px;''>";
                foreach ($row as $product) {

                    if($product->picture_link == null ){
                        $picture = "/images/products/default_product2.jpg";
                    }else{
                        $picture = $product->picture_link;
                    }

                  $result = $result."<div class='col-md-3'>
                            <div class='single-product'>
                                <div class='product-f-image'>
                                <input type='hidden' name='data-search' value='".$search_data."'/><br/>
                                <img src='".$picture."' class='img-product' alt=''>
                                    <div class='product-hover'>
                                    <a href='".$product->shopper_link."' class='add-to-cart-link'><i class='fa fa-shopping-cart' target='_blank'></i>Compare</a>
                                    <a href='".$product->shopper_link."' class='view-details-link'><i class='fa fa-link' target='_blank'></i> See details</a>
                                    </div>
                                </div>

                                <h2><a href='single-product.html'>".$product->product_name."</a></h2>
                                <div class='product-carousel-price'>
                                    <ins>RM ".$product->product_price."</ins> <del>RM ".$product->product_price."</del>
                                    <br/>
                                </div>
                                </div>
                            </div>";

                }
                $result = $result ."</div>";
            }

            $result = $result."<br><div align='center'>".$products->render()."</div>";
        }
        return $result;
//

       //search product that match to search data above...


    }

    public function show($id)
    {
        $retailer = Retailer::find($id);

        $product = \DB::table('products')
            ->select('products.id','products.product_name','products.product_price','products.product_brand','products.product_rating','products.product_reviews','products.picture_link','products.shopper_link','products.category_id', 'retailers.picture_link as retailer_picture' )
            ->join('enrollment', 'products.id', '=', 'enrollment.product_id')
            ->join('retailers', 'enrollment.retailer_id', '=', 'retailers.id')
            ->where('retailers.id' , '=' , $retailer->id)
            ->get();

        return \View::make('/product/baseOnRetailer')->with('products' , $product)->with('title', $retailer->id.'&#39; Products ');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function productCollection(){

        $products = Products::all();
        $collection = [];

        foreach ($products as $product) {

            // $neproducts = Products::where('product_name', 'LIKE', '%'.$explode[2].'%')
            //                         // ->where('id', '<>', $product->id)
            //                         ->get();

            // foreach ($neproducts as $prow) {
            //     $collection[] =  $prow->product_name;
            // }
            // dd($neproducts->product_name);
                // if($neproducts){
                //     $newarray[] = array();
                //         foreach ($neproducts as $neproduct) {
                //             $newarray = $neproduct->product_name;
                //         }

                //     $collection[] = $newarray;
                // }


        }

        // dd($collection);
    }
    //request from ajax angular....ng-controller=productsController
    public function listAll(){
      $products = \DB::table('products')
        ->select('products.*','brand_title','category_title','condition_title')
        ->join('brand','products.brand_id','=', 'brand.id')
        ->join('category','products.category_id','=','category.id')
        ->join('condition', 'products.condition_id','=','condition.id')
        ->orderBy('products.product_reviews', 'DESC')
        ->take(8)
        ->get();

      return $products;
    }
    public function searchFulltext(){
        $data = \Input::get('search');

        $products = Products::whereRaw("MATCH(product_name) AGAINST(? IN BOOLEAN MODE)", array($data))->get();

        dd($products);

    }
}
