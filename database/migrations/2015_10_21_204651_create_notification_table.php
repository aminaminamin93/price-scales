<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notif_title');
            $table->string('notif_content');
            $table->boolean('unread')->default(0);
            $table->string('notif_type');
            $table->integer('notif_from');
            $table->integer('notif_to')->unsigned();
            $table->timestamps();

            $table->foreign('notif_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}
