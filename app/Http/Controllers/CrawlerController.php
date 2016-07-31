<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;
use App\Website;
use App\Retailer;
class CrawlerController extends Controller
{
	

    public function listWebsiteCrawler(){
      $retailers = \DB::table('retailers')
          ->join('website', 'retailers.id', '=', 'website.retailer_id')
          ->join('crawler', 'website.crawler_id', '=', 'crawler.id')
          // ->select('retailers.id','retailers.retailer_name','website.website_crawler' )
          // ->select('pdf.pricelist_id','pdf.crawler_id', 'pdf.retailer_id','price_list.pricelist_file','retailers.retailer_name', 'retailers.retailer_email', 'retailers.retailer_site')
          ->get();

      return $retailers;
    }

    // public function checkDeadLink(Request $request){
    //     return $request->get('id');
    // }


    public function checkDeadLink(Request $request) {
     

      // $totalcounts = \DB::table('products')
      //   ->select(\DB::raw('count(id) as total_count'))
      //   ->where('brand_id','=', $request->get('id'))
      //   ->get();

      // $total = 0;
      // foreach ($totalcounts as $totalcount) 
      // {
      //   $total += $totalcount->total_count;  
      // }
      
      // return $total;
      // $from = 1;
      // $to = 10;
      // echo $total.'<br>';
     
      $products = \DB::table('products')
        // ->whereBetween('id', array($from,$to))
        ->where('brand_id','=', $request->get('id'))
        ->get();
      

      $deadlink = array();
      foreach ($products as $url) {
        if(!$url->shopper_link == null){
          $array = get_headers($url->shopper_link);
          $string = $array[0];
          if(!strpos($string,"200")) {
              $deadlink [] = array('id'=>$url->id);
          } 
        }
        
      }

      return $deadlink;
        

    }

    public function deleteDeadlink(Request $request){
    
      $products = \DB::table('products')->where('id',$request->get('id'))->delete();

      
      if(!$products){
        return "not deleted";
      }else{
        return $request->get('id')." is deleted";
      }
    }

}
