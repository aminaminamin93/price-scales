<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class WebsiteTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
    public function run()
    {
      $websites = array(
         ['website_crawler' => 'mudahmy1','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'mudahmy2','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'mudahmy3','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'mudahmy4','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'mudahmy5','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'mudahmy6','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'mudahmy7','crawler_id'=>'1','retailer_id'=>'1', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'lelong1','crawler_id'=>'1','retailer_id'=>'2', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'lelong2','crawler_id'=>'1','retailer_id'=>'2', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'lelong3','crawler_id'=>'1','retailer_id'=>'2', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'lelong4','crawler_id'=>'1','retailer_id'=>'2', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'lelong5','crawler_id'=>'1','retailer_id'=>'2', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'lelong6','crawler_id'=>'1','retailer_id'=>'2', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay1','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay2','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay3','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay4','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay5','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay6','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay7','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay8','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay9','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['website_crawler' => 'ebay10','crawler_id'=>'1','retailer_id'=>'3', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
        );

       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       DB::table('website')->truncate();
       DB::table('crawler')->truncate();

       foreach ($websites as $website) {
          DB::table('website')->insert([
             'website_crawler' =>  $website['website_crawler'],
             'crawler_id' =>  $website['crawler_id'],
             'retailer_id' =>  $website['retailer_id'],
             'created_at' => $website['created_at'],
             'updated_at' => $website['updated_at']
         ]);
       }
    }
}


// public function run()
// {
//   $ = array(
//      ['retailer_name' => '', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
//     );
//    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//    DB::table('')->truncate();
//    DB::table('')->truncate();
//    DB::table('')->truncate();
//
//    foreach ( as ) {
//       DB::table('')->insert([
//          '' =>  [''],
//          'created_at' => ['created_at'],
//          'updated_at' => ['updated_at']
//      ]);
//    }
// }
