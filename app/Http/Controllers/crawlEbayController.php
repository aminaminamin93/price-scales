<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;
use DB;

class crawlEbayController extends Controller
{

	
	public function indexNewPhones()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.ebay.com.my/sch/Mobile-Phones-/9355/i.html?rt=nc&LH_ItemCondition=1000|1500");
		$crawler->addContent($html);
	
		//------------------filter category------------------------
		$category = $crawler->filter('span.kwcat b')->text();
		//print_r($category);
		//---------------------------------------------------------

		//------------------filter condition-----------------------
		$condition = $crawler->filter('span.cbx')->text();
		//print_r($condition);
		//---------------------------------------------------------

		$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.ebay.com.my/sch/Mobile-Phones-/9355/i.html?LH_ItemCondition=1000|1500&_pgn='.$i.'&_ipg=200&rt=nc';
				$html = file_get_contents( $url );
				$crawler->addContent($html);


			   	global $products;
			   	global $rank;

				   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
				   {
				      	$products[$i]['title'] = $crawler->text();
				      	$products[$i]['url'] = $crawler->attr('href');
				   });

				   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
				   {
				   		$toReplace = array('RM', ',');
					 	$with = array('','');
				        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
				   });

				   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
				   {
				       $products[$i]['image'] = $crawler->attr('src');
				   });

				   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
				   {
				       $products[$i]['shipping'] = $crawler->text();
				   });

				   ++$rank;

			$i++;
			//print_r($products);
			}

		});

		//-------------insert data using model--------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Mobile Phones')
   				{
   					$category_id = 1;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'New(selected)')
   				{
   					$condition_id = 1;
   					$retailer_id = 3;
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
   		//---------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexUsedPhones()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/Mobile-Phones-/9355/i.html?_ipg=200&rt=nc&LH_ItemCondition=3000';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Mobile Phones')
   				{
   					$category_id = 1;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'Used(selected)')
   				{
   					$condition_id = 2;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexNewTablets()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/iPads-Tablets-eReaders-/171485/i.html?_sac=1&LH_ItemCondition=1000';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'iPads, Tablets, eReaders')
   				{
   					$category_id = 2;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'New(selected)')
   				{
   					$condition_id = 1;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexUsedTablets()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/iPads-Tablets-eReaders-/171485/i.html?_sac=1&LH_ItemCondition=3000';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'iPads, Tablets, eReaders')
   				{
   					$category_id = 2;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'Used(selected)')
   				{
   					$condition_id = 2;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexNewNotebooks()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/Laptops-Netbooks-/175672/i.html?rt=nc&LH_ItemCondition=1000|1500';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Laptops & Netbooks')
   				{
   					$category_id = 3;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'New(selected)')
   				{
   					$condition_id = 1;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";	
	}

	public function indexUsedNotebooks()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/Laptops-Netbooks-/175672/i.html?rt=nc&LH_ItemCondition=3000';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Laptops & Netbooks')
   				{
   					$category_id = 3;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'Used(selected)')
   				{
   					$condition_id = 2;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";	
	}

	public function indexNewCameras()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.ebay.com.my/sch/Digital-Cameras-/31388/i.html?rt=nc&LH_ItemCondition=1000&_trksid=p2045573.m1684");
		$crawler->addContent($html);

			
		//------------------filter category------------------------
		$category = $crawler->filter('span.kwcat b')->text();
		//print_r($category);
		//---------------------------------------------------------

		//------------------filter condition-----------------------
		$condition = $crawler->filter('span.cbx')->text();
		//print_r($condition);
		//---------------------------------------------------------

		$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			for($i=2; $i<=5;) {

				$url = 'http://www.ebay.com.my/sch/Digital-Cameras-/31388/i.html?LH_ItemCondition=1000&_pgn='.$i.'&_skc=200&rt=nc';
				$html = file_get_contents( $url );
				$crawler->addContent($html);


			   	global $products;
			   	global $rank;

				   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
				   {
				      	$products[$i]['title'] = $crawler->text();
				      	$products[$i]['url'] = $crawler->attr('href');
				   });

				   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
				   {
				   		$toReplace = array('RM', ',');
					 	$with = array('','');
				        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
				   });

				   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
				   {
				       $products[$i]['image'] = $crawler->attr('src');
				   });

				   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
				   {
				       $products[$i]['shipping'] = $crawler->text();
				   });

				   ++$rank;
			$i++;
			//print_r($products);
			}

		});

		//-------------insert data using model--------------
   			foreach ($products as $pro) 
   			{

   				if($category == 'Digital Cameras')
   				{
   					$category_id = 4;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'New(selected)')
   				{
   					$condition_id = 1;
   					$retailer_id = 3;
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
   		//---------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";	
	}

	public function indexUsedCameras()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/Digital-Cameras-/31388/i.html?rt=nc&LH_ItemCondition=3000';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Digital Cameras')
   				{
   					$category_id = 4;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'Used(selected)')
   				{
   					$condition_id = 2;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexNewTVs()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			$url = 'http://www.ebay.com.my/sch/Televisions-/11071/i.html?rt=nc&LH_ItemCondition=1000&_trksid=p2045573.m1684';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
		 	$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition------------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//----------------------------------------------------------

			$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			   global $products;
			   global $rank;

			   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
			   {
			      	$products[$i]['title'] = $crawler->text();
			      	$products[$i]['url'] = $crawler->attr('href');
			   });

			   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
			   {	
			   		$toReplace = array('RM', ',');
				 	$with = array('','');
			        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
			   });

			   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['image'] = $crawler->attr('src');
			   });

			   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
			   {
			       $products[$i]['shipping'] = $crawler->text();
			   });

			   ++$rank;

			});

			//dd($products);

		//---------------insert data using model---------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Televisions')
   				{
   					$category_id = 5;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'New(selected)')
   				{
   					$condition_id = 1;
   					$retailer_id = 3;
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
   		//-----------------------------------------------------

   		return "<div class='alert alert-success'>Successfully crawler site</div>";
	}

	public function indexNewGames()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

		$html = file_get_contents("http://www.ebay.com.my/sch/Consoles-/139971/i.html?rt=nc&LH_ItemCondition=1000|4000|5000|6000");
		$crawler->addContent($html);

		//------------------filter category------------------------
		$category = $crawler->filter('span.kwcat b')->text();
		//print_r($category);
		//---------------------------------------------------------

		//------------------filter condition-----------------------
		$condition = $crawler->filter('span.cbx')->text();
		//print_r($condition);
		//---------------------------------------------------------

		$crawler->filter('ul#ListViewInner')->each(function ($crawler) {

			for($i=1; $i<5;) {

				$url = 'http://www.ebay.com.my/sch/Consoles-/139971/i.html?LH_ItemCondition=1000|4000|5000|6000&_pgn='.$i.'&_skc=200&rt=nc';
				$html = file_get_contents( $url );
				$crawler->addContent($html);

				global $products;
			   	global $rank;

				   $rank = $crawler->filter('h3.lvtitle a')->each(function ($crawler, $i) use (&$products) 
				   {
				      	$products[$i]['title'] = $crawler->text();
				      	$products[$i]['url'] = $crawler->attr('href');
				   });

				   $rank = $crawler->filter('ul.lvprices.left.space-zero')->each(function ($crawler, $i) use (&$products) 
				   {
				   		$toReplace = array('RM', ',');
					 	$with = array('','');
				        $products[$i]['price'] = str_replace($toReplace, $with, $crawler->filter('li.lvprice.prc')->last()->text());
				   });

				   $rank = $crawler->filter('a.img.imgWr2 img')->each(function ($crawler, $i) use (&$products) 
				   {
				       $products[$i]['image'] = $crawler->attr('src');
				   });

				   $rank = $crawler->filter('span.ship')->each(function ($crawler, $i) use (&$products) 
				   {
				       $products[$i]['shipping'] = $crawler->text();
				   });

				   ++$rank;

			$i++;
			}

			//dd($products);
		});
		
		//-------------insert data using model--------------
   			foreach ($products as $pro) 
   			{
   				
   				if($category == 'Consoles')
   				{
   					$category_id = 6;
   				}else{
   					$category_id = 7;
   				}

   				if($condition == 'Brand New(selected)')
   				{
   					$condition_id = 1;
   					$retailer_id = 3;
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
   		//---------------------------------------------------

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