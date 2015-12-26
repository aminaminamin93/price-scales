<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class RetailerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $retailers = array(
    				['retailer_name' => 'MudahDotMY', 'retailer_email' => 'mudah@gmail.com','retailer_site' => 'www.mudah.my','retailer_description' => 'mudah online shopping','picture_link' => 'http://nolink.jpg','created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['retailer_name' => 'Lelong', 'retailer_email' => 'lelong@gmail.com','retailer_site' => 'www.lelong.com.my','retailer_description' => 'lelong online shopping','picture_link' => 'http://nolink.jpg', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['retailer_name' => 'EbayMalaysia', 'retailer_email' => 'ebaymalaysia@gmail.com','retailer_site' => 'www.ebay.com.my','retailer_description' => 'malaysian online shopping','picture_link' => 'http://nolink.jpg', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['retailer_name' => 'Cycom', 'retailer_email' => '','retailer_site' => 'cycom@gmail.com','retailer_description' => 'cycom pricelist','picture_link' => 'http://nolink.jpg', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['retailer_name' => 'C-ZONE', 'retailer_email' => '','retailer_site' => 'c-zone@gmail.com','retailer_description' => 'c-zone pricelist','picture_link' => 'http://nolink.jpg', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['retailer_name' => 'VIEW-NET', 'retailer_email' => '','retailer_site' => 'view-net@gmail.com','retailer_description' => 'view-net pricelist','picture_link' => 'http://nolink.jpg', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
				);
      	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      	DB::table('retailers')->truncate();

      	foreach ($retailers as $retailer) {
      		 DB::table('retailers')->insert([
              'retailer_name' =>  $retailer['retailer_name'],
              'retailer_email' =>  $retailer['retailer_email'],
              'retailer_site' =>  $retailer['retailer_site'],
              'retailer_description' =>  $retailer['retailer_description'],
              'created_at' => $retailer['created_at'],
              'updated_at' => $retailer['updated_at']
          ]);
      	}
    }
}
