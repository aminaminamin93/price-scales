<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
    				['category_title' => 'Mobile Phones', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['category_title' => 'Tablets', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['category_title' => 'Computers', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['category_title' => 'Cameras', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['category_title' => 'TVs', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['category_title' => 'Games', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['category_title' => 'Accessories', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
				);
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('products')->truncate();
    	DB::table('category')->truncate();

    	foreach ($categories as $category) {
    		 DB::table('category')->insert([
            'category_title' =>  $category['category_title'],
            'created_at' => $category['created_at'],
            'updated_at' => $category['updated_at']
        ]);
    	}
    }
}
