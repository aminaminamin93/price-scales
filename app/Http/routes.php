<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use App\User;
use App\Products;
use App\Retailer;
use Carbon\Carbon;
use App\Favorite;
use App\DB;
use App\Category;
use App\Crawler;
use App\Pdf;
use App\PriceList;
use App\Website;


Route::get('angularAjax', function(){
    return \View::make('/admin/testing/testing')->with('title','Angular Ajax');
});
Route::post('/angularAjax/submit/',array('before'=>'VerifyCsrfToken', 'uses'=>'testerController@angularAjax'));


Route::get('/processCrawler/test/{id}', function($id){
    return $id;
});


Route::get('testCrawler', 'crawlEbayController@index');
Route::get('testLoader', function(){
    return View::make('loader')->with('title', 'Loader');
});
Route::get('/loader', function(){
    if(Request::ajax()){
       $users =  \DB::table('users')->get();
        return $users;
    }
});
Route::get('testSearch', function(){
  return View::make('search');
});
Route::post('/codeTester', 'testerController@searchFulltext');

Route::get('/email/view/', function(){
  return View::make('/email/index');
});
Route::get('/sending/email', 'newsletterController@index');
//
//Route::get('/', function() {
//    $products = Products::all();
//
//    return view('home/index')->with('title', 'Welcome')->with('products', $products);
//});

//Route::get('login', function(){
//    return View::make('login/index')->with('title', 'Login page');
//});


//socialite authentication
// Route::get('/', array('as'=>'home', function () {
//     if(Auth::check()) return 'Welcome back, '. Auth::user()->username. '<a href="/logout">logout</a>';
//
//     return View::make('/auth/login');
//
//
// }));


//login using socialite authentication {facebook, google, twitter etc}
get('login/{provider}', 'SocialiteController@login');
get('login/cancel', function(){ return View::make('/');   });

//end of socialite authentication
Route::get('/', array('as'=>'home', 'uses'=>'productsController@home'));

Route::get('/auth/login', array('uses'=>'sessionsController@index'));
Route::get('/auth/login/{email}','sessionsController@login_newsletter'); //login from newsletter
Route::get('/logout', array('middleware'=>'auth', 'uses'=>'sessionsController@destroy'));
Route::resource('sessions', 'sessionsController@store');
Route::get('/user_register_confirm', 'sessionsController@login');

Route::get('/auth/register', array('before'=>'CSRF', 'uses'=>'sessionsController@register') );
Route::get('/auth/reset', array('as'=>'reset_password', 'uses'=>'sessionsController@reset') );
Route::post('/reset', 'sessionsController@email');
Route::post('/password/recover/', 'sessionsController@recover');
Route::get('/auth/recover_password/{provider}', 'sessionsController@recoverPassword');
Route::post('/create', 'sessionsController@create');
Route::post('/contact/sending', 'messageController@contactUs');
Route::get('myAccount',array('middleware'=>'auth', 'uses'=>'sessionsController@myAccount'));

Route::get('/product/compare/{id}', 'productsController@view_comparison');
Route::post('/product/comparetable/', 'productsController@comparetable');
// Route::post('/product/comparetable/', function(Request $request){
//
// });
Route::get('/product/details/{id}', 'productsController@details');
Route::get('/product/related/{id}', 'productsController@related');
Route::get('/product/relatedCompare/{id}', 'productsController@relatedCompare');  //call from ajax angular.js
Route::get('/product/top/{id}', 'productsController@top');   //call from ajax angular.js
Route::get('/product/viewall', 'productsController@index');

Route::get('/favorite/view', array('middleware' => 'auth','uses'=>'FavoriteController@index'));
Route::get('/favorite/add/{id}', array('middleware'=>'auth' , 'uses'=>'FavoriteController@create'));
Route::get('/favorite/list', array('middleware'=>'auth' , 'uses'=>'FavoriteController@favorites'));
Route::get('/favorite/remove/{id}', array('middleware'=>'auth' , 'uses'=>'FavoriteController@destroy'));
Route::get('/product/list-all', 'productsController@listAll');
Route::get('/product/list-category', 'categoryController@index');
Route::get('/product/list-brands', 'brandController@index');
Route::get('/product/list-conditions', 'conditionController@index');
Route::post('/product/search/all', 'productsController@searchByForm');

//products widget area
Route::get('/products/topViewed', 'productsController@topViewed');
Route::get('/products/recentlyViewed', 'productsController@recentlyViewed');
Route::get('/products/newAdded', 'productsController@newAdded');

Route::get('/product/department/allcategory/', 'categoryController@allcategory');
Route::get('/product/department/allbrand/', 'brandController@allbrand');
Route::post('/product/department/category/', 'categoryController@category');
Route::post('/product/department/brand/', 'brandController@brand');

Route::get('/product/department/all/{data}', 'productsController@products');



//Route::
Route::post('product/form/search', 'productsController@search');


Route::get('/product/form/search/',function(){
    if(Request::ajax()){
        $search_data = Input::get('search');
        $data = explode('_', Input::get('search'));
        $search = $data[0];
        $brand = $data[1];
        $category = $data[2];
        $price_min = $data[3];
        $price_max = $data[4];
        $condition = $data[5];

         $products = \DB::table('products')
                ->where(function($query) use ($category, $brand) {
                    $category == 0 ? $query->where('category_id', '<>', $category) : $query->where('category_id','=', $category);
                    $brand == 0 ? $query->where('brand_id', 'NOT LIKE', '%'.$brand.'%') : $query->where('brand_id','=', $brand);

//                ->where('product_name', 'LIKE', '%'.$search.'%')
//                ->where('product_name', 'LIKE', '%'.$search.'%')
//                ->get();


                })
                ->paginate(12);

        return View::make('/product/product_render')
        ->with('search_data', $search_data)
        ->with('title', 'Products')
        ->with('products', $products)
        ->render();
    }

});
//    $products = Products::all();
////        where('product_name', 'LIKE', '%'.$search.'%')
////            ->orWhere('product_brand', 'LIKE', '%'.$brand.'%')
////            ->orWhere('category_id', '=', $category)
////            ->orWhereBetween('product_price', array($price_min, $price_max))
////    ->get();
////            return $search;
//    $result = "";
//    foreach($products as $product){
//
//        $result = $result."<br/>".Html::link('/view/products/'.$product->id , $product->product_name , array('style'=>'text-decoration:none;'));
//    }
//    return $result;
//);

//route for newsletter subscribe
Route::get('newsletter/subscribe/{email}', 'newsletterController@subscribe');


//for admin
Route::get('/admin/login', 'AdminController@index');
Route::get('/admin', array('middleware' => 'administrator', 'uses'=>'AdminController@admin'));
Route::post('/admin/get_login', array('as'=>'adminlogin', 'uses'=>'AdminController@getLogin'));
Route::get('/admin/logs_setting', array('middleware'=>'administrator', 'uses'=>'AdminController@logsSetting'));
Route::get('/crawler/list', array('middleware'=>'administrator', 'uses'=>'AdminController@crawler'));
Route::get('/admin/logout', array('middleware' => 'administrator', 'uses'=>'AdminController@destroy'));
Route::get('/settings-general', array('middleware' =>'administrator' , 'uses'=>'AdminController@generalSettings' ));
Route::post('/admin/generalsettings', array('middleware' =>'administrator' , 'uses'=>'AdminController@save'));
Route::get('admin/profile/{id}' , array('middleware'=> 'administrator', 'uses'=>'AdminController@profile'));



Route::get('retailer/view', array('middleware'=>'administrator', 'uses'=>'RetailerController@view'));
Route::get('retailer/view/{id}', array('middleware'=>'administrator', 'uses'=>'RetailerController@viewByid'));
Route::get('/retailer/contact/{id}' ,array('middleware'=>'administrator', 'uses'=>'RetailerController@contact'));
Route::get('retailer/delete/{id}',  array('middleware' => 'administrator' , 'uses' =>'RetailerController@destroy'));
Route::post('/sending/{id}',  array('middleware' => 'administrator' , 'uses' =>'RetailerController@sendEmail'));
Route::post('retailer/save/{id}', array('middleware' => 'administrator' , 'uses' =>'RetailerController@update'));
Route::post('retailer/register', array('middleware' => 'administrator' , 'uses' =>'RetailerController@create'));
Route::get('retailer/edit/{id}', array('middleware' => 'administrator' , 'uses' =>'RetailerController@edit'));




Route::get('/view/product/{id}',  'productsController@show');  //view product base on retailer chosen

Route::get('/view/products', array('middleware' => 'administrator' , 'uses' => 'productsController@view'));

Route::get('/view/products/{id}', array('middleware'=>'administrator', 'uses'=>'productsController@viewProduct'));
////ajax search
//Route::post('product/search', array('middleware'=>'ajax', function(){
//
//}));
Route::post('/product/search', array('middleware'=>'administrator', function(){
    if(Request::ajax()){
        $data = Input::get('search');

        $products = \DB::table('products')
            ->where('product_name', 'LIKE', '%'.$data.'%')
            ->get();

        $result = "";
        foreach($products as $product){

            $result = $result."<br/>".Html::link('/view/products/'.$product->id , $product->product_name , array('style'=>'text-decoration:none;'));
        }
        return $result;

    }
}));

Route::get('searchText', function(){
    return \View::make('/search');
});
Route::post('searchFulltext', 'productsController@searchFulltext');


Route::get('/list-crawler-pdf',  array('middleware'=>'administrator', 'uses'=>'PdfParserController@listPdf'));
Route::get('/crawler/start/pdf/{pricelist}/{retailername}',  array('middleware'=>'administrator', 'uses'=>'PdfParserController@StartExtractPdf'));
Route::get('/crawler/processdata/pdf/{retailername}', array('middleware'=>'administrator', 'uses'=>'PdfParserController@ProcessDataPdf'));

//test pdfcrawler

Route::post('/pdfcrawler/extract/', array('middleware' => 'administrator','before'=>'VerifyCsrfToken', 'uses'=>'PdfParserController@StartExtractPdf'));
Route::post('/pdfcrawler/process/', array('middleware' => 'administrator', 'before'=>'VerifyCsrfToken','uses'=>'PdfParserController@ProcessDataPdf'));
Route::post('/pdfcrawler/saveCrawler/', array('middleware' => 'administrator', 'before'=>'VerifyCsrfToken','uses'=>'PdfParserController@saveCrawler'));
Route::post('/pdfcrawler/deleteCrawler/',array('middleware' => 'administrator', 'before'=>'VerifyCsrfToken','uses'=>'PdfParserController@deleteCrawler'));
//end



Route::get('/list-crawler-website',  array('middleware'=>'administrator', 'uses'=>'CrawlerController@listWebsiteCrawler'));
Route::get('/system-logs', array('middleware'=>'administrator', 'uses'=>'AdminController@systemlogs'));

//testing upload photo
Route::get('photo', function(){
    return View::make('testing/upload');
});
Route::post('/upload', 'UploadphotoController@upload');




//date
Route::get('getdatetime/', function(){
    $dt = new \DateTime;
    date_default_timezone_get();

 return View::make('/viewdate')->with('dt', $dt);
});
//end of date

Route::get('testing', function(){
    return View::make('admin/layouts/message');
});


//pagination page
Route::get('/product/form/search/{page}', function($page){
    $_page = mysql_real_escape_string($page);
   $products = Products::paginate(5);
   if(!$products) die();
    return View::make('/product/pagination')->with('products', $products);
});
//mailbox route;;;;

Route::get('admin/mailbox', function(){
  return \View::make('admin/mailbox/index')->with('title', 'mailbox');
});

Route::get('list-mailbox', array('middleware' => 'administrator' ,'uses'=>'messageController@index'));
Route::get('total-mailbox', array('middleware' => 'administrator', 'uses'=>'messageController@totalMessage' ));

//pdf parser Routing
Route::get('pdfparser', 'PdfParserController@index');



// -----------------Route for Website crawler-----------------------------

Route::get('/crawler/startcrawler/website/mudahmy1', 'crawlMudahController@indexPhones');
Route::get('/crawler/startcrawler/website/mudahmy2', 'crawlMudahController@indexTablets');
Route::get('/crawler/startcrawler/website/mudahmy3', 'crawlMudahController@indexDesktops');
Route::get('/crawler/startcrawler/website/mudahmy4', 'crawlMudahController@indexNotebooks');
Route::get('/crawler/startcrawler/website/mudahmy5', 'crawlMudahController@indexCameras');
Route::get('/crawler/startcrawler/website/mudahmy6', 'crawlMudahController@indexTVs');
Route::get('/crawler/startcrawler/website/mudahmy7', 'crawlMudahController@indexGames');

//----------------------------------------------------------


//------------------crawlLelongController--------------------

Route::get('/crawler/startcrawler/website/lelong1', 'crawlLelongController@indexPhones');
Route::get('/crawler/startcrawler/website/lelong2', 'crawlLelongController@indexTablets');
Route::get('/crawler/startcrawler/website/lelong3', 'crawlLelongController@indexNotebooks');
Route::get('/crawler/startcrawler/website/lelong4', 'crawlLelongController@indexCameras');
Route::get('/crawler/startcrawler/website/lelong5', 'crawlLelongController@indexTVs');
Route::get('/crawler/startcrawler/website/lelong6', 'crawlLelongController@indexGames');

//-----------------------------------------------------------

//-------------------crawlEbayController---------------------

Route::get('/crawler/startcrawler/website/ebay1', 'crawlEbayController@indexNewPhones');
Route::get('/crawler/startcrawler/website/ebay2', 'crawlEbayController@indexUsedPhones');
Route::get('/crawler/startcrawler/website/ebay3', 'crawlEbayController@indexNewTablets');
Route::get('/crawler/startcrawler/website/ebay4', 'crawlEbayController@indexUsedTablets');
Route::get('/crawler/startcrawler/website/ebay5', 'crawlebayController@indexNewNotebooks');
Route::get('/crawler/startcrawler/website/ebay6', 'crawlebayController@indexUsedNotebooks');
Route::get('/crawler/startcrawler/website/ebay7', 'crawlebayController@indexNewCameras');
Route::get('/crawler/startcrawler/website/ebay8', 'crawlebayController@indexUsedCameras');
Route::get('/crawler/startcrawler/website/ebay9', 'crawlebayController@indexNewTVs');
Route::get('/crawler/startcrawler/website/ebay10', 'crawlebayController@indexNewGames');

//-----------------------------------------------------------
