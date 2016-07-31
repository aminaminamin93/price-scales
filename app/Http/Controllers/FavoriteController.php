<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Products;
use App\Favorite;
use Carbon\carbon;
use Session;
use Redirect;
use Auth;
class FavoriteController extends Controller
{

    public function index(){
        return \View::make('member/favorites')
            ->with('title', 'Favorites');
    }

    public function favorites(){
      return \DB::table('favorite')
                ->join('users', 'favorite.user_id','=','users.id')
                ->join('products','favorite.product_id','=','products.id')
                ->where('user_id','=', Auth::user()->id)
                ->select('products.*')
                ->get();
    }

    public function create($id)
    {
        $favo_product = \DB::table('favorite')
            ->where('product_id', '=', $id)
            ->where('user_id', '=', Auth::user()->id )
            ->first();


        if(is_null($favo_product)){
            $created_at = Carbon::now('Asia/Kuala_lumpur');
            $updated_at = Carbon::now('Asia/Kuala_lumpur');

            $favorite = new Favorite;
            $favorite->user_id = Auth::user()->id;
            $favorite->product_id = $id;
            $favorite->created_at = $created_at;
            $favorite->updated_at = $updated_at;

            $favorite->save();
            Session::flash('alert-success', 'Product successfully add to your favorite list');
            return \View::make('/member/favorites')->with('title', 'Favorites');
        }else{
            Session::flash('alert-warning', 'Your already add to your favorite');
            return \View::make('/member/favorites')->with('title', 'Favorites');
        }
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {

    }


    public function destroy(Request $request)
    {

      $products = \DB::table('favorite')
        ->where('product_id','=',$request->get('id'))
        ->where('user_id','=', Auth::user()->id)
        ->first();

      if($products){
        $deleted = Favorite::find($products->id);
        $deleted->delete();
      }

      return \DB::table('favorite')
                ->join('users', 'favorite.user_id','=','users.id')
                ->join('products','favorite.product_id','=','products.id')
                ->where('user_id','=', Auth::user()->id)
                ->select('products.*')
                ->get();

    }
}
