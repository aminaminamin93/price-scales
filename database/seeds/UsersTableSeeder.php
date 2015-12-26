<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = array(
    				['user_firstname' => 'super', 'user_lastname' => 'admin','user_email' => 'super.admin@gmail.com','password' => bcrypt('superadmin'),'provider_id' => mt_rand(100000000, 999999999) ,'role_id' => 1 ,'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],

    				['user_firstname' => 'admin', 'user_lastname' => 'lower','user_email' => 'admin@gmail.com','password' => bcrypt('admin'),'provider_id' => mt_rand(100000000, 999999999),'role_id' => 2,'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],

    				['user_firstname' => 'firstmember', 'user_lastname' => 'lastmember','user_email' => 'fistlast@gmail.com','password' => bcrypt('member'),'provider_id' =>  mt_rand(100000000, 999999999),'role_id' => 3,'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
				);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('users')->truncate();

    	foreach ($users as $user) {
    		 DB::table('users')->insert([
    		'user_firstname' =>  $user['user_firstname'],
    		'user_lastname' =>  $user['user_lastname'],
    		'user_email' =>  $user['user_email'],
    		'password' =>  $user['password'],
    		'provider_id' =>  $user['provider_id'],
            'role_id' =>  $user['role_id'],
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at']
        ]);
    	}
    }
}
