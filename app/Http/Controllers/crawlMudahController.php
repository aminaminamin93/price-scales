<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;
use DB;

class crawlMudahController extends Controller
{

	public function indexPhones()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents('http://www.mudah.my/Malaysia/Mobile-Phones-and-Gadgets-for-sale-3020?lst=0&fs=1&cg=3020&w=3&so=1&st=s&categorylevel_one=1');
    	$crawler->addContent($html);

		//------------------filter category-------------------------------------------------------------
    	$toReplace = array('Item Type', 'Tablets', 'Repair/Servicing', 'Others');
		$with = array('','','','');
		$category = str_replace($toReplace, $with, $crawler->filter('select#categorylevel_one')->text());
		//-----------------------------------------------------------------------------------------------

		$crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/Mobile-Phones-and-Gadgets-for-sale-3020?o='.$i.'&categorylevel_one=1&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

					global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

	        		++$rank;
	        $i++;

	   		}
	   		//dd($products);
		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{
	   				if($category == 'Phones')
	   				{
	   					$category_id = 1;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
					}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
		   				$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------

   			return "<div class='alert alert-success'>Successfully crawler site</div>";
	}


	public function indexTablets()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.mudah.my/Malaysia/Mobile-Phones-and-Gadgets-for-sale-3020?lst=0&fs=1&cg=3020&w=3&so=1&st=s&categorylevel_one=2");
    	$crawler->addContent($html);

		//------------------filter category------------------------------------------------------------
    	$toReplace = array('Item Type', 'Phones', 'Repair/Servicing', 'Others');
		$with = array('','','','');
		$category = str_replace($toReplace, $with, $crawler->filter('select#categorylevel_one')->text());
		//----------------------------------------------------------------------------------------------

    	$crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/Mobile-Phones-and-Gadgets-for-sale-3020?o='.$i.'&categorylevel_one=2&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

				global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

					++$rank;
			$i++;
			//dd($products);
	   		}

		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{

	   				if($category == 'Tablets')
	   				{
	   					$category_id = 2;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
	   				}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
	   					$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------
   			return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexDesktops()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.mudah.my/Malaysia/Computers-and-Accessories-for-sale-3060?lst=0&fs=1&cg=3060&w=3&so=1&st=s&categorylevel_one=1");
    	$crawler->addContent($html);

		//------------------filter category------------------------------------------------------------------------------
    	$toReplace = array('Item Type', 'Notebooks', 'Graphics/Display/Monitors', 'CPU/Ram/Mainboard', 'Mouse/Keyboard', 'Other Computer Parts', 'Repair/Servicing', 'Printers', 'Others');
		$with = array('','','','','','','','','');
		$category =  str_replace($toReplace, $with, $crawler->filter('select#categorylevel_one')->text());
		//---------------------------------------------------------------------------------------------------------------

	    $crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/Computers-and-Accessories-for-sale-3060?o='.$i.'&categorylevel_one=1&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

				global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

					++$rank;
			$i++;
			//print_r($products);
	   		}

		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{

	   				if($category == 'Desktops')
	   				{
	   					$category_id = 3;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
	   				}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
	   					$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------
   			return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexNotebooks()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.mudah.my/Malaysia/Computers-and-Accessories-for-sale-3060?lst=0&fs=1&cg=3060&w=3&so=1&st=s&categorylevel_one=2");
    	$crawler->addContent($html);

		//------------------filter category----------------------------------------------------------------
    	$toReplace = array('Item Type', 'Desktops', 'Graphics/Display/Monitors', 'CPU/Ram/Mainboard', 'Mouse/Keyboard', 'Other Computer Parts', 'Repair/Servicing', 'Printers', 'Others');
		$with = array('','','','','','','','','');
		$category =  str_replace($toReplace, $with, $crawler->filter('select#categorylevel_one')->text());
		//--------------------------------------------------------------------------------------------------

  		$crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/Computers-and-Accessories-for-sale-3060?o='.$i.'&categorylevel_one=2&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

				global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

					++$rank;
			$i++;
			//print_r($products);
	   		}

		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{

	   				if($category == 'Notebooks')
	   				{
	   					$category_id = 3;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
	   				}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
	   					$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------
   			return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexCameras()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.mudah.my/Malaysia/Cameras-and-Photography-for-sale-3100?lst=0&fs=1&cg=3100&w=3&so=1&st=s&categorylevel_one=1");
    	$crawler->addContent($html);

		//------------------filter category-------------------------------------------
    	$toReplace = array('Item Type 1', 'Camera Accessories');
		$with = array('','');
		$category = str_replace($toReplace, $with, $crawler->filter('select#categorylevel_one')->text());
		//----------------------------------------------------------------------------


	    $crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/Cameras-and-Photography-for-sale-3100?o='.$i.'&categorylevel_one=1&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

				global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

					++$rank;
			$i++;
			//print_r($products);
	   		}

		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{

	   				if($category == 'Cameras & Lenses')
	   				{
	   					$category_id = 4;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
	   				}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
	   					$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------
   			return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexTVs()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.mudah.my/Malaysia/TV-Audio-Video-for-sale-3040?lst=0&fs=1&cg=3040&w=3&so=1&st=s&categorylevel_one=1");
    	$crawler->addContent($html);

		//------------------filter category------------------------
    	$toReplace = array('Item Type', 'DVD/Other Players', 'Audio (Earphones and Personal)', 'Audio (Speakers and Home Theatre)', 'Audio/Video Accessories', 'Others');
		$with = array('','','','','','');
		$category = str_replace($toReplace, $with, $crawler->filter('select#categorylevel_one')->text());
		//----------------------------------------------------------

		$crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/TV-Audio-Video-for-sale-3040?o='.$i.'&categorylevel_one=1&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

				global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

					++$rank;
			$i++;
			//print_r($products);
	   		}

		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{

	   				if($category == 'TVs')
	   				{
	   					$category_id = 5;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
	   				}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
	   					$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------
   			return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexGames()
	{

		$crawler = new Crawler();

		//-------------extract all product details------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.mudah.my/Malaysia/Games-and-Consoles-for-sale-3120?lst=0&fs=1&cg=3120&w=3&so=1&st=s");
    	$crawler->addContent($html);

		//------------------filter category------------------------
		$category = $crawler->filter('a[title="See all ads in Games & Consoles category"] span')->text();
		//----------------------------------------------------------

	 	$crawler->filter('div.listing_thumbs')->each(function ($crawler) {

	    	for($i=2; $i<=5;) {

				$url = 'http://www.mudah.my/Malaysia/Games-and-Consoles-for-sale-3120?o='.$i.'&q=&so=1&th=1';
    			$html = file_get_contents( $url );
    			$crawler->addContent($html);

				global $rank;
			    global $products;

					$rank = $crawler->filter('h2.list_title.truncate a')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['title'] = $crawler->text();
						$products[$i]['url'] = $crawler->attr('href');
					});

					$rank = $crawler->filter('div.ads_price')->each(function ($crawler, $i) use (&$products)
					{
						$toReplace = array(' ', 'RM');
						$with = array('','');
						$products[$i]['price'] = str_replace($toReplace, $with, $crawler->text());
					});

					$rank = $crawler->filter('li.listing_thumbs_image img')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['image'] = $crawler->attr('src');
					});

					$rank = $crawler->filter('div.location')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['location'] = str_replace(' ', '', $crawler->children()->siblings()->text());
					});

					$rank = $crawler->filter('div[title="Condition"]')->each(function ($crawler, $i) use (&$products)
					{
						$products[$i]['condition'] = $crawler->text();
					});

					++$rank;
			$i++;
			//dd($products);
	   		}

		});

   			//--------------insert data using model-----------------
   			foreach ($products as $pro)
   			{

	   				if($category == 'Games & Consoles')
	   				{
	   					$category_id = 6;
	   					$retailer_id = 1;
	   				}else{
	   					$category_id = 7;
	   					$retailer_id = 1;
	   				}

	   				$arrProduct = explode(' ', $pro['title']);
	   				$brands = \DB::table('brand')->whereIn('brand_title' , $arrProduct)->get();
	   				if($brands)
	   				{
	   					foreach ($brands as $brand)
	   					{
	   						$brand_id = $brand->id;
	   					}
	   				}else{
	   					$brand_id = 1;
	   				}

	   				$product_name = $pro['title'];
					$shopper_link = $pro['url'];
	   				$product_price = $pro['price'];
	   				$picture_link = str_replace('thumbs', 'images', $pro['image']);
	   				$product_location = $pro['location'];

	   				if ($pro['condition'] == 'New')
					{
						$condition_id = 1;
					}else{
	   					$condition_id = 2;
					}

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
						$product->product_location = $product_location;
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
   			//--------------------------------------------------------
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

	// check if url is valid






}


?>
