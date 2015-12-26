<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CrawlerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $crawlers = array(
         ['crawler_startdate' => Carbon::now(), 'crawler_enddate' => Carbon::now(),'crawler_type' => 'Website','created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['crawler_startdate' => Carbon::now(), 'crawler_enddate' => Carbon::now(),'crawler_type' => 'Website','created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['crawler_startdate' => Carbon::now(), 'crawler_enddate' => Carbon::now(),'crawler_type' => 'PDF','created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
        );
       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       DB::table('crawler')->truncate();

       foreach ($crawlers as $crawler) {
          DB::table('crawler')->insert([
             'crawler_startdate' =>  $crawler['crawler_startdate'],
             'crawler_enddate' =>  $crawler['crawler_enddate'],
             'crawler_type' =>  $crawler['crawler_type'],
             'created_at' => $crawler['created_at'],
             'updated_at' => $crawler['updated_at']
         ]);
      }
    }
}
