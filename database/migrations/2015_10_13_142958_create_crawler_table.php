<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; 

class CreateCrawlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawler', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('crawler_startdate');
            $table->dateTime('crawler_enddate');
            $table->string('crawler_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crawler');
    }
}
