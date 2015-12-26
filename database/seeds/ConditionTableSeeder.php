<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $conditions = array(
    				['condition_title' => 'New', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['condition_title' => 'Used (Second hands)', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['condition_title' => 'Others', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
				);
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('products')->truncate();
    	DB::table('condition')->truncate();

    	foreach ($conditions as $condition) {
    		 DB::table('condition')->insert([
            'condition_title' =>  $condition['condition_title'],
            'created_at' => $condition['created_at'],
            'updated_at' => $condition['updated_at']
        ]);
    	}
    }
}
