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
}
