<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;

class crawlLelongController extends Controller
{
	
	public function indexPhones()
	{

		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------

		global $products;
		$products = array();

		$html = file_get_contents("http://www.lelong.com.my/phone-and-tablet/handphone/");
		$crawler->addContent($html);
				
		//------------------extract retailer logo------------------------
		//$retailer_logo = $crawler->filter('div#top1Logo img')->attr('src');
		//---------------------------------------------------------------
		
		//------------------filter category------------------------
		$category = $crawler->filter('a[href="/phone-and-tablet/handphone/"]')->text();
		//---------------------------------------------------------

		$crawler->filter('div.item4inline')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.lelong.com.my/phone-and-tablet/handphone/?D='.$i;
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
				global $rank;

					$rank = $crawler->filter('span.catalogTitle')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = str_replace('//', '', $crawler->parents()->attr('href'));
					});

					$rank = $crawler->filter('div.catalogPrice b')->each(function ($crawler, $i) use (&$products) 
					{
						$toReplace = array('RM', ',');
					 	$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('div.catalog-wrap')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->parents()->attr('id');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['shipping'] = $crawler->children()->text();
					});

					++$rank;
			$i++;
			//print_r($products);
			} 
		
		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{

	   		$product = new Products;
	   				
	   		if($category == 'Handphone')
	   		{
	   			$product->category_id = 1;	
				$product->condition_id = 3;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$product->brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$product->brand_id = 204;
	   		}
   				
   			$product->product_name = $pro['title'];
   			$product->shopper_link = $pro['url'];
   			$product->product_price = $pro['price'];
   			$product->picture_link = $pro['image'];
   			$product->product_shipping = $pro['shipping'];
   				
   			$product->save();
   		}
   		//-------------------------------------------------------
	}

	public function indexTablets()
	{
		$crawler = new Crawler();

		//--------------------extract all product details----------------------

		global $products;
		$products = array();

		$html = file_get_contents("http://www.lelong.com.my/computer-and-software/tablet/");
		$crawler->addContent($html);

		//------------------extract retailer logo------------------------
		//$retailer_logo = $crawler->filter('div#top1Logo img')->attr('src');
		//---------------------------------------------------------------

		//---------------------------filter category-------------------------------
		$category = $crawler->filter('a[href="/computer-and-software/tablet/"]')->text();
		//-------------------------------------------------------------------------

		$crawler->filter('div.item4inline')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.lelong.com.my/computer-and-software/tablet/?D='.$i;
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
				global $rank;

					$rank = $crawler->filter('span.catalogTitle')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['title'] = $crawler->text();
					    $products[$i]['url'] = str_replace('//', '', $crawler->parents()->attr('href'));
					});

					$rank = $crawler->filter('div.catalogPrice b')->each(function ($crawler, $i) use (&$products) 
					{
					   	$toReplace = array('RM', ',');
				 		$with = array('','');
					    $products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('div.catalog-wrap')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['image'] = $crawler->parents()->attr('id');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['shipping'] = $crawler->children()->text();
					 });

				   	++$rank;

			$i++;
			//print_r($products);
			}

		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{

	   		$product = new Products;
	   				
	   		if($category == 'Tablet')
	   		{
	   			$product->category_id = 2;	
				$product->condition_id = 3;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$product->brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$product->brand_id = 204;
	   		}
   				
   			$product->product_name = $pro['title'];
   			$product->shopper_link = $pro['url'];
   			$product->product_price = $pro['price'];
   			$product->picture_link = $pro['image'];
   			$product->product_shipping = $pro['shipping'];
   				
   			$product->save();
   		}
   		//-------------------------------------------------------
	
	}

	public function indexNotebooks()
	{
		$crawler = new Crawler();

		//--------------------extract all product details----------------------

		global $products;
		$products = array();

		$html = file_get_contents("http://www.lelong.com.my/computer-and-software/notebook/notebook/");
		$crawler->addContent($html);

		//------------------extract retailer logo------------------------
		//$retailer_logo = $crawler->filter('div#top1Logo img')->attr('src');
		//---------------------------------------------------------------

		//---------------------------filter category-------------------------------
		$category = $crawler->filter('a[href="/computer-and-software/notebook/notebook/"]')->text();
		//-------------------------------------------------------------------------

		$crawler->filter('div.item4inline')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.lelong.com.my/computer-and-software/notebook/notebook/?D='.$i;
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
				global $rank;

					$rank = $crawler->filter('span.catalogTitle')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['title'] = $crawler->text();
					    $products[$i]['url'] = str_replace('//', '', $crawler->parents()->attr('href'));
					 });

					$rank = $crawler->filter('div.catalogPrice b')->each(function ($crawler, $i) use (&$products) 
					{
					   	$toReplace = array('RM', ',');
				 		$with = array('','');
					    $products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('div.catalog-wrap')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['image'] = $crawler->parents()->attr('id');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['shipping'] = $crawler->children()->text();
					});

				   ++$rank;
			$i++;
			//print_r($products);
			}
			
		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{

	   		$product = new Products;
	   				
	   		if($category == 'Notebook')
	   		{
	   			$product->category_id = 3;	
				$product->condition_id = 3;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$product->brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$product->brand_id = 204;
	   		}
   				
   			$product->product_name = $pro['title'];
   			$product->shopper_link = $pro['url'];
   			$product->product_price = $pro['price'];
   			$product->picture_link = $pro['image'];
   			$product->product_shipping = $pro['shipping'];
   				
   			$product->save();
   		}
   		//-------------------------------------------------------
	
	}

	public function indexCameras()
	{
		$crawler = new Crawler();

		//--------------------extract all product details----------------------

		global $products;
		$products = array();

		$html = file_get_contents("http://www.lelong.com.my/camera-and-camcorder/digital-cameras/");
		$crawler->addContent($html);
		
		//------------------extract retailer logo------------------------
		//$retailer_logo = $crawler->filter('div#top1Logo img')->attr('src');
		//---------------------------------------------------------------

		//---------------------------filter category-------------------------------
		$category = $crawler->filter('a[href="/camera-and-camcorder/digital-cameras/"]')->text();
		//-------------------------------------------------------------------------

		$crawler->filter('div.item4inline')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.lelong.com.my/camera-and-camcorder/digital-cameras/?D='.$i;
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
				global $rank;

					$rank = $crawler->filter('span.catalogTitle')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['title'] = $crawler->text();
					    $products[$i]['url'] = str_replace('//', '', $crawler->parents()->attr('href'));
					});

					$rank = $crawler->filter('div.catalogPrice b')->each(function ($crawler, $i) use (&$products) 
					{
					   	$toReplace = array('RM', ',');
				 		$with = array('','');
					    $products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('div.catalog-wrap')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['image'] = $crawler->parents()->attr('id');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['shipping'] = $crawler->children()->text();
					});

				   ++$rank;
			$i++;
			//print_r($products);
			}
				
		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{

	   		$product = new Products;
	   				
	   		if($category == 'Digital Cameras')
	   		{
	   			$product->category_id = 4;	
				$product->condition_id = 3;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$product->brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$product->brand_id = 204;
	   		}
   				
   			$product->product_name = $pro['title'];
   			$product->shopper_link = $pro['url'];
   			$product->product_price = $pro['price'];
   			$product->picture_link = $pro['image'];
   			$product->product_shipping = $pro['shipping'];
   				
   			$product->save();
   		}
   		//-------------------------------------------------------
	
	}

	public function indexTVs()
	{
		$crawler = new Crawler();

		//--------------------extract all product details----------------------

		global $products;
		$products = array();

		$html = file_get_contents("http://www.lelong.com.my/electronics-and-appliances/tv/");
		$crawler->addContent($html);
		
		//------------------extract retailer logo------------------------
		//$retailer_logo = $crawler->filter('div#top1Logo img')->attr('src');
		//---------------------------------------------------------------

		//---------------------------filter category-------------------------------
		$category = $crawler->filter('a[href="/electronics-and-appliances/tv/"]')->text();
		//-------------------------------------------------------------------------

		$crawler->filter('div.item4inline')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.lelong.com.my/electronics-and-appliances/tv/?D='.$i;
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
				global $rank;

					$rank = $crawler->filter('span.catalogTitle')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['title'] = $crawler->text();
					    $products[$i]['url'] = str_replace('//', '', $crawler->parents()->attr('href'));
					});

					$rank = $crawler->filter('div.catalogPrice b')->each(function ($crawler, $i) use (&$products) 
					{
					   	$toReplace = array('RM', ',');
				 		$with = array('','');
					    $products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('div.catalog-wrap')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['image'] = $crawler->parents()->attr('id');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['shipping'] = $crawler->children()->text();
					});

				   ++$rank;
			$i++;
			//print_r($products);
			}
		
		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{

	   		$product = new Products;
	   				
	   		if($category == 'TV')
	   		{
	   			$product->category_id = 5;	
				$product->condition_id = 3;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$product->brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$product->brand_id = 204;
	   		}
   				
   			$product->product_name = $pro['title'];
   			$product->shopper_link = $pro['url'];
   			$product->product_price = $pro['price'];
   			$product->picture_link = $pro['image'];
   			$product->product_shipping = $pro['shipping'];
   				
   			$product->save();
   		}
   		//-------------------------------------------------------
	
	}

	public function indexGames()
	{
		$crawler = new Crawler();

		//--------------------extract all product details----------------------

		global $products;
		$products = array();

		$html = file_get_contents("http://www.lelong.com.my/toys-and-games/game-console/");
		$crawler->addContent($html);

		//------------------extract retailer logo------------------------
		//$retailer_logo = $crawler->filter('div#top1Logo img')->attr('src');
		//---------------------------------------------------------------

		//---------------------------filter category-------------------------------
		$category = $crawler->filter('a[href="/toys-and-games/game-console/"]')->text();
		//-------------------------------------------------------------------------

		$crawler->filter('div.item4inline')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.lelong.com.my/toys-and-games/game-console/?D='.$i;
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
				global $rank;

					$rank = $crawler->filter('span.catalogTitle')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['title'] = $crawler->text();
					    $products[$i]['url'] = str_replace('//', '', $crawler->parents()->attr('href'));
					});

					$rank = $crawler->filter('div.catalogPrice b')->each(function ($crawler, $i) use (&$products) 
					{
					   	$toReplace = array('RM', ',');
				 		$with = array('','');
					    $products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('div.catalog-wrap')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['image'] = $crawler->parents()->attr('id');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
					    $products[$i]['shipping'] = $crawler->children()->text();
					});

				   ++$rank;
			$i++;
			//print_r($products);
			}
		
		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{

	   		$product = new Products;
	   				
	   		if($category == 'Game Console')
	   		{
	   			$product->category_id = 6;	
				$product->condition_id = 3;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$product->brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$product->brand_id = 204;
	   		}
   				
   			$product->product_name = $pro['title'];
   			$product->shopper_link = $pro['url'];
   			$product->product_price = $pro['price'];
   			$product->picture_link = $pro['image'];
   			$product->product_shipping = $pro['shipping'];
   				
   			$product->save();
   		}
   		//-------------------------------------------------------
	
	}

}

?>