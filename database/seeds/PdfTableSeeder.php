<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class PdfTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $pdfs = array(
         ['pricelist_file' => 'http://images-cdn.lowyat.net/pricelists/PCHardware/Cycom/pricelist01_merged.pdf', 'crawler_id'=>'3', 'retailer_id'=>'4', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['pricelist_file' => 'http://images-cdn.lowyat.net/pricelists/PCHardware/C-Zone/pchardware-czone.pdf', 'crawler_id'=>'3', 'retailer_id'=>'5', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
         ['pricelist_file' => 'http://images-cdn.lowyat.net/pricelists/PCHardware/Viewnet/pchardware-viewnet.pdf', 'crawler_id'=>'3', 'retailer_id'=>'6', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
        );
       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       DB::table('pdf')->truncate();
       DB::table('crawler')->truncate();

       foreach ($pdfs as $pdf) {
          DB::table('pdf')->insert([
             'pricelist_file' =>  $pdf['pricelist_file'],
             'crawler_id' =>  $pdf['crawler_id'],
             'retailer_id' =>  $pdf['retailer_id'],
             'created_at' => $pdf['created_at'],
             'updated_at' => $pdf['updated_at']
         ]);
       }
    }
}
