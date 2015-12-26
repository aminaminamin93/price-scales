<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ConditionTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(PdfTableSeeder::class);
        $this->call(WebsiteTableSeeder::class);
        $this->call(RetailerTableSeeder::class);
        $this->call(CrawlerTableSeeder::class);
        // $this->call(RetailerTableSeeder::class);
        // $this->call(CrawlerTableSeeder::class);
        // $this->call(PricelistTableSeeder::class);

        Model::reguard();
    }
}
