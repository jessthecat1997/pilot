<?php

use Illuminate\Database\Seeder;
use database\seeds\RoleTableSeeder;
use database\seeds\UserTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role comes before User seeder here.
    	$this->call(RoleTableSeeder::class);
  // User seeder will use the roles above created.
    	$this->call(UserTableSeeder::class);
    }
}
