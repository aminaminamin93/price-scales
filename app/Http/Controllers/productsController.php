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
          ->where('products.brand_id', '=', $product->brand_id)

          ->get();


        return \View::make('product/compareProduct')
            ->with('title', $product->product_name)
            ->with('products', $product)
            ->with('compareProducts', $products);
    }
    public function comparetable(Request $request){
      return $request->get('comparedid');
      // if( $request->isXmlHttpRequest())
      //   {
      //       if($request->get('id')){
      //           return $request->get('id');
      //       }else{
      //           return "fdsfsdfd";
      //       }
      //   }
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

    public function searchByForm(Request $request){

      $brand = $request->get('brand');
      $category = $request->get('category');
      $condition = $request->get('condition');

      $products = \DB::table('products')

        ->where(function($query) use ($category, $brand, $condition) {
          $category == 0 ? $query->where('category_id', '<>', $category) : $query->where('category_id','=', $category);
          $brand == 0 ? $query->where('brand_id', '<>', $brand) : $query->where('brand_id','=', $brand);
          $condition == 0 ? $query->where('condition_id', '<>', $condition) : $query->where('condition_id','=', $condition);
        })
        ->orWhereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($request->get('searchText')))
        ->whereBetween('product_price',[$request->get('priceLow'),$request->get('priceHigh')])
        ->get();

        return $products;
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

    //request from ajax angular....ng-controller=productsController
    public function listAll(){
      $products = \DB::table('products')
        ->select('products.*','brand_title','category_title','condition_title')
        ->join('brand','products.brand_id','=', 'brand.id')
        ->join('category','products.category_id','=','category.id')
        ->join('condition', 'products.condition_id','=','condition.id')
        ->orderBy('created_at', 'ASD')
        ->take(16)
        ->get();
        $newarr = array();
        foreach ($products as $product) {
          $compareproducts = \DB::table('products')
            ->select(DB::raw('count(*) as counter'))
            ->where('id' , '<>', $product->id)
            ->where('brand_id', '=', $product->brand_id)
            ->where('category_id','=',$product->category_id)
            ->whereRaw('MATCH(product_name) AGAINST(? IN BOOLEAN MODE)', array($product->product_name))
            ->get();
            foreach ($compareproducts as $compareproduct) {
              if($compareproduct->counter >= 1){
                $comparetable = true;
              }else{
                $comparetable = false;
              }
            }
          $newarr[] = [ 'id'=>$product->id,
                        'product_name'=>$product->product_name,
                        'product_price'=>$product->product_price,
                        'product_price_temp'=>$product->product_price_temp,
                        'product_favorite'=>$product->product_favorite,
                        'product_reviews'=>$product->product_reviews,
                        'picture_link'=>$product->picture_link,
                        'shopper_link'=>$product->shopper_link,
                        'comparetable'=>$comparetable
                      ];
        }
        return $newarr;
      // return $products;
    }
    public function searchFulltext(){
        $data = \Input::get('search');

        $products = Products::whereRaw("MATCH(product_name) AGAINST(? IN BOOLEAN MODE)", array($data))->get();

        dd($products);

    }
}
