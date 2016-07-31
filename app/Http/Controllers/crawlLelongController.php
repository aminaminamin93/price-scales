<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;
use DB;

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

					$rank = $crawler->filter('div.catalogImg-wrap img')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->attr('data-original');
					});

					$rank = $crawler->filter('div.catalogIcon')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['shipping'] = $crawler->children()->text();
					});

					++$rank;
			$i++;
			
			} 
			//print_r($products);
		});

		//--------------insert data using model-----------------
	   	foreach ($products as $pro) 
	   	{
	   				
	   		if($category == 'Handphone')
	   		{
	   			$category_id = 1;	
				$condition_id = 3;
				$retailer_id = 2;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$brand_id = 1;
	   		}
   				
   			$product_name = $pro['title'];
   			$shopper_link = $pro['url'];
   			$product_price = $pro['price'];
   			$picture_link = $pro['image'];
   			$product_shipping = $pro['shipping'];
   				
   			//----------------------------------------update products for change price-----------------------------------------
			$product_id = 0;
			$productExistFilter = $this->productExistFilter($product_name,$shopper_link,$picture_link,$brand_id,$product_id);
			if($productExistFilter){
				//this if $productExistFilter return true......will update product from database
				if($product_id !== 0){
					$product = Products::find($product_id);
					$product_price_temp = $product->product_price;

					$product->product_price = $product_price;
					$product->product_price_temp = $product_price_temp;
					$product->save();
				}

			}else{

				//this if $productExistFilter return false........will create new product to database...
				$product = new Products;
				$product->product_name = $product_name;
				$product->product_price = $product_price;
				$product->product_price_temp = $product_price;
				$product->product_shipping = $product_shipping;
				$product->picture_link = $picture_link;
				$product->shopper_link = $shopper_link;
				$product->category_id = $category_id;
				$product->brand_id = $brand_id;
				$product->condition_id = $condition_id;
				$product->retailer_id = $retailer_id;
				$product->save();
			}
			//-------------------------------------------------------------------------------------------------------------------

   		}
   		//-------------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
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

					$rank = $crawler->filter('div.catalogImg-wrap img')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->attr('data-original');
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
	   				
	   		if($category == 'Tablet')
	   		{
	   			$category_id = 2;	
				$condition_id = 3;
				$retailer_id = 2;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$brand_id = 1;
	   		}
   				
   			$product_name = $pro['title'];
   			$shopper_link = $pro['url'];
   			$product_price = $pro['price'];
   			$picture_link = $pro['image'];
   			$product_shipping = $pro['shipping'];
   				
   			//----------------------------------------update products for change price-----------------------------------------
			$product_id = 0;
			$productExistFilter = $this->productExistFilter($product_name,$shopper_link,$picture_link,$brand_id,$product_id);
			if($productExistFilter){
				//this if $productExistFilter return true......will update product from database
				if($product_id !== 0){
					$product = Products::find($product_id);
					$product_price_temp = $product->product_price;

					$product->product_price = $product_price;
					$product->product_price_temp = $product_price_temp;
					$product->save();
				}

			}else{

				//this if $productExistFilter return false........will create new product to database...
				$product = new Products;
				$product->product_name = $product_name;
				$product->product_price = $product_price;
				$product->product_price_temp = $product_price;
				$product->product_shipping = $product_shipping;
				$product->picture_link = $picture_link;
				$product->shopper_link = $shopper_link;
				$product->category_id = $category_id;
				$product->brand_id = $brand_id;
				$product->condition_id = $condition_id;
				$product->retailer_id = $retailer_id;
				$product->save();
			}
			//-------------------------------------------------------------------------------------------------------------------

   		}
   		//-------------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
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

					$rank = $crawler->filter('div.catalogImg-wrap img')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->attr('data-original');
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
		
	   		if($category == 'Notebook')
	   		{
	   			$category_id = 3;	
				$condition_id = 3;
				$retailer_id = 2;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$brand_id = 1;
	   		}
   				
   			$product_name = $pro['title'];
   			$shopper_link = $pro['url'];
   			$product_price = $pro['price'];
   			$picture_link = $pro['image'];
   			$product_shipping = $pro['shipping'];
   				
   			//----------------------------------------update products for change price-----------------------------------------
			$product_id = 0;
			$productExistFilter = $this->productExistFilter($product_name,$shopper_link,$picture_link,$brand_id,$product_id);
			if($productExistFilter){
				//this if $productExistFilter return true......will update product from database
				if($product_id !== 0){
					$product = Products::find($product_id);
					$product_price_temp = $product->product_price;

					$product->product_price = $product_price;
					$product->product_price_temp = $product_price_temp;
					$product->save();
				}

			}else{

				//this if $productExistFilter return false........will create new product to database...
				$product = new Products;
				$product->product_name = $product_name;
				$product->product_price = $product_price;
				$product->product_price_temp = $product_price;
				$product->product_shipping = $product_shipping;
				$product->picture_link = $picture_link;
				$product->shopper_link = $shopper_link;
				$product->category_id = $category_id;
				$product->brand_id = $brand_id;
				$product->condition_id = $condition_id;
				$product->retailer_id = $retailer_id;
				$product->save();
			}
			//-------------------------------------------------------------------------------------------------------------------

   		}
   		//-------------------------------------------------------
	
		return "<div class='alert alert-success'>Successfully crawler site</div>";
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

					$rank = $crawler->filter('div.catalogImg-wrap img')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->attr('data-original');
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
		
	   		if($category == 'Digital Cameras')
	   		{
	   			$category_id = 4;	
				$condition_id = 3;
				$retailer_id = 2;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$brand_id = 1;
	   		}
   				
   			$product_name = $pro['title'];
   			$shopper_link = $pro['url'];
   			$product_price = $pro['price'];
   			$picture_link = $pro['image'];
   			$product_shipping = $pro['shipping'];
   				
   			//----------------------------------------update products for change price-----------------------------------------
			$product_id = 0;
			$productExistFilter = $this->productExistFilter($product_name,$shopper_link,$picture_link,$brand_id,$product_id);
			if($productExistFilter){
				//this if $productExistFilter return true......will update product from database
				if($product_id !== 0){
					$product = Products::find($product_id);
					$product_price_temp = $product->product_price;

					$product->product_price = $product_price;
					$product->product_price_temp = $product_price_temp;
					$product->save();
				}

			}else{

				//this if $productExistFilter return false........will create new product to database...
				$product = new Products;
				$product->product_name = $product_name;
				$product->product_price = $product_price;
				$product->product_price_temp = $product_price;
				$product->product_shipping = $product_shipping;
				$product->picture_link = $picture_link;
				$product->shopper_link = $shopper_link;
				$product->category_id = $category_id;
				$product->brand_id = $brand_id;
				$product->condition_id = $condition_id;
				$product->retailer_id = $retailer_id;
				$product->save();
			}
			//-------------------------------------------------------------------------------------------------------------------

   		}
   		//-------------------------------------------------------
	
		return "<div class='alert alert-success'>Successfully crawler site</div>";
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

					$rank = $crawler->filter('div.catalogImg-wrap img')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->attr('data-original');
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
	   				
	   		if($category == 'TV')
	   		{
	   			$category_id = 5;	
				$condition_id = 3;
				$retailer_id = 2;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$brand_id = 1;
	   		}
   				
   			$product_name = $pro['title'];
   			$shopper_link = $pro['url'];
   			$product_price = $pro['price'];
   			$picture_link = $pro['image'];
   			$product_shipping = $pro['shipping'];
   				
   			//----------------------------------------update products for change price-----------------------------------------
			$product_id = 0;
			$productExistFilter = $this->productExistFilter($product_name,$shopper_link,$picture_link,$brand_id,$product_id);
			if($productExistFilter){
				//this if $productExistFilter return true......will update product from database
				if($product_id !== 0){
					$product = Products::find($product_id);
					$product_price_temp = $product->product_price;

					$product->product_price = $product_price;
					$product->product_price_temp = $product_price_temp;
					$product->save();
				}

			}else{

				//this if $productExistFilter return false........will create new product to database...
				$product = new Products;
				$product->product_name = $product_name;
				$product->product_price = $product_price;
				$product->product_price_temp = $product_price;
				$product->product_shipping = $product_shipping;
				$product->picture_link = $picture_link;
				$product->shopper_link = $shopper_link;
				$product->category_id = $category_id;
				$product->brand_id = $brand_id;
				$product->condition_id = $condition_id;
				$product->retailer_id = $retailer_id;
				$product->save();
			}
			//-------------------------------------------------------------------------------------------------------------------

   		}
   		//-------------------------------------------------------
	
		return "<div class='alert alert-success'>Successfully crawler site</div>";
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

					$rank = $crawler->filter('div.catalogImg-wrap img')->each(function ($crawler, $i) use (&$products) 
					{
						$products[$i]['image'] = $crawler->attr('data-original');
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

	   		if($category == 'Game Console')
	   		{
	   			$category_id = 6;	
				$condition_id = 3;
				$retailer_id = 2;
			}

			$arrProduct = explode(' ', $pro['title']);	
	   		$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   		if($brands)
	   		{
	   			foreach ($brands as $brand) 
	   			{
	   				$brand_id = $brand->id;
	   			}	
	   		}
	   		else
	   		{
	   			$brand_id = 1;
	   		}
   				
   			$product_name = $pro['title'];
   			$shopper_link = $pro['url'];
   			$product_price = $pro['price'];
   			$picture_link = $pro['image'];
   			$product_shipping = $pro['shipping'];
   				
   			//----------------------------------------update products for change price-----------------------------------------
			$product_id = 0;
			$productExistFilter = $this->productExistFilter($product_name,$shopper_link,$picture_link,$brand_id,$product_id);
			if($productExistFilter){
				//this if $productExistFilter return true......will update product from database
				if($product_id !== 0){
					$product = Products::find($product_id);
					$product_price_temp = $product->product_price;

					$product->product_price = $product_price;
					$product->product_price_temp = $product_price_temp;
					$product->save();
				}

			}else{

				//this if $productExistFilter return false........will create new product to database...
				$product = new Products;
				$product->product_name = $product_name;
				$product->product_price = $product_price;
				$product->product_price_temp = $product_price;
				$product->product_shipping = $product_shipping;
				$product->picture_link = $picture_link;
				$product->shopper_link = $shopper_link;
				$product->category_id = $category_id;
				$product->brand_id = $brand_id;
				$product->condition_id = $condition_id;
				$product->retailer_id = $retailer_id;
				$product->save();
			}
			//-------------------------------------------------------------------------------------------------------------------

   		}
   		//-------------------------------------------------------
		
		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	private function productExistFilter($product_name,$shopper_link,$picture_link,$brand_id, &$product_id){

		$products = \DB::table('products')
						->where('shopper_link', 'LIKE', $shopper_link)
						->where('brand_id', '=', $brand_id)
						->first();

		if($products){
			$product_id = $products->id;
			return true; //means the product is exist
		}else{
			return false; //means the product is not exist
		}
	}


}

?>