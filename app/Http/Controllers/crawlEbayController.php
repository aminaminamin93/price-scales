<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;

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

   				$product = new Products;
   				
   				if($category == 'Mobile Phones')
   				{
   					$product->category_id = 1;
   				}
   				if($condition == 'New(selected)')
   				{
   					$product->condition_id = 1;
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
   		//---------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'Mobile Phones')
   				{
   					$product->category_id = 1;
   				}
   				if($condition == 'Used(selected)')
   				{
   					$product->condition_id = 2;
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
   		//-----------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'iPads, Tablets, eReaders')
   				{
   					$product->category_id = 2;
   				}
   				if($condition == 'New(selected)')
   				{
   					$product->condition_id = 1;
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
   		//-----------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'iPads, Tablets, eReaders')
   				{
   					$product->category_id = 2;
   				}
   				if($condition == 'Used(selected)')
   				{
   					$product->condition_id = 2;
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
   		//-----------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'Laptops & Netbooks')
   				{
   					$product->category_id = 3;
   				}
   				if($condition == 'New(selected)')
   				{
   					$product->condition_id = 1;
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
   		//-----------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'Laptops & Netbooks')
   				{
   					$product->category_id = 3;
   				}
   				if($condition == 'Used(selected)')
   				{
   					$product->condition_id = 2;
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
   		//-----------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'Digital Cameras')
   				{
   					$product->category_id = 4;
   				}
   				if($condition == 'New(selected)')
   				{
   					$product->condition_id = 1;
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
   		//---------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'Digital Cameras')
   				{
   					$product->category_id = 4;
   				}
   				if($condition == 'Used(selected)')
   				{
   					$product->condition_id = 2;
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
   		//-----------------------------------------------------
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

   				$product = new Products;
   				
   				if($category == 'Televisions')
   				{
   					$product->category_id = 5;
   				}
   				if($condition == 'New(selected)')
   				{
   					$product->condition_id = 1;
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
   		//-----------------------------------------------------
	}

	public function indexNewGames()
	{
		$crawler = new Crawler();
		
		//--------------------extract all product details----------------------
		global $products;
		$products = array();

			for($i=1; $i<2; $i++) {

			$url = 'http://www.ebay.com.my/sch/Consoles-/139971/i.html?LH_ItemCondition=1000|4000|5000|6000&_pgn='.$i.'&_skc=200&rt=nc';
			$html = file_get_contents( $url );
			$crawler->addContent($html);

			//------------------filter category------------------------
			$category = $crawler->filter('span.kwcat b')->text();
			//print_r($category);
			//---------------------------------------------------------

			//------------------filter condition-----------------------
			$condition = $crawler->filter('span.cbx')->text();
			//print_r($condition);
			//---------------------------------------------------------

			//echo "<br><br><strong>Page</strong>" . $i . " > " . $url . "<br><br>";

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
		}
		//-------------insert data using model--------------
   			foreach ($products as $pro) 
   			{

   				$product = new Products;
   				
   				if($category == 'Consoles')
   				{
   					$product->category_id = 6;
   				}
   				if($condition == 'Brand New(selected)')
   				{
   					$product->condition_id = 1;
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
   		//---------------------------------------------------
	}


	
}

?>