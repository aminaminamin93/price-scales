<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name');
            $table->double('product_price');
            $table->double('product_price_temp');
            $table->double('product_rating');
            $table->integer('product_reviews');
            $table->string('picture_link');
            $table->string('shopper_link');
            $table->string('product_location');
            $table->string('product_shipping');
            $table->integer('condition_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();

           $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
           $table->foreign('condition_id')->references('id')->on('condition')->onDelete('cascade');
           $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade');

        });

        DB::statement('ALTER TABLE products ADD FULLTEXT search(product_name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function($table) {
          $table->dropIndex('search');
        });
        Schema::drop('products');
    }
}
