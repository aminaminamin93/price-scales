<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = array(
        			['brand_title' => 'Other', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Asus', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Xiaomi', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Blackberry', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Lenovo', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Apple', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Nokia', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Sony', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'HTC', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'LG', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Oppo', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Motorola', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Alcatel', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'HP', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Acer', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Dell', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Canon', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Asus', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Toshiba', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Intel', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'msi', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Seagate', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Western Digital', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Nikon', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'Canon', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'SHARP', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'PHILIPS', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['brand_title' => 'XBOX', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
				);
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('products')->truncate();
    	DB::table('brand')->truncate();

    	foreach ($brands as $brand) {
    		 DB::table('brand')->insert([
            'brand_title' =>  $brand['brand_title'],
            'created_at' => $brand['created_at'],
            'updated_at' => $brand['updated_at']
        ]);
    	}
    }
}
