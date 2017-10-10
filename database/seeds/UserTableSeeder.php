<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_employee = Role::where('name', 'Admin')->first();
    	$employee = new User();
    	$employee->name = 'admin';
    	$employee->email = 'adminadmin';
    	$employee->password = bcrypt('admin');
    	$employee->save();
    }
}
