<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_employee = new Role();
    	$role_employee->name = 'Admin';
    	$role_employee->save();
    	$role_manager = new Role();
    	$role_manager->name = 'Broker';
    	$role_manager->save();
    	$role_manager = new Role();
    	$role_manager->name = 'Trucking Manager';
    	$role_manager->save();
    	$role_manager = new Role();
    	$role_manager->name = 'Billing Manager';
    	$role_manager->save();
    }
}
