<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = array(
    				['role_title' => 'super admin', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['role_title' => 'admin', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()],
    				['role_title' => 'member', 'created_at' =>Carbon::now() ,'updated_at' => Carbon::now()]
				);
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('users')->truncate();
    	DB::table('role')->truncate();

    	foreach ($roles as $role) {
    		 DB::table('role')->insert([
            'role_title' =>  $role['role_title'],
            'created_at' => $role['created_at'],
            'updated_at' => $role['updated_at']
        ]);
    	}
       
    }
}
