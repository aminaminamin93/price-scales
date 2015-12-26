<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_firstname');
            $table->string('user_lastname');
            $table->string('user_email')->unique();
            $table->string('user_phone');
            $table->string('password');
            $table->string('avatar');
            $table->string('provider_id')->unique();
            $table->dateTime('last_login');
            $table->string('remember_token')->nullable();
            $table->integer('role_id')->default('0')->unsigned();
            $table->timestamps();


            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
