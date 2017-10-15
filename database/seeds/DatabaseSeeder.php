<?php

use Illuminate\Database\Seeder;
use database\seeds\EmployeesTableSeeder;
use database\seeds\EmployeeTypesTableSeeder;
use database\seeds\UsersTableSeeder;
class DatabaseSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(EmployeeTypesTableSeeder::class);
    	$this->call(EmployeesTableSeeder::class);
  // User seeder will use the roles above created.
    	$this->call(UsersTableSeeder::class);
    }
}
