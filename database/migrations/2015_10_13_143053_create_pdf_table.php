<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
 
class CreatePdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pricelist_file');
            $table->integer('crawler_id')->unsigned();
            $table->integer('retailer_id')->unsigned();
            $table->timestamps();

            $table->foreign('crawler_id')->references('id')->on('crawler')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('retailer_id')->references('id')->on('retailers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pdf');
    }
}
