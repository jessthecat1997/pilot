<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin',
            'password' => bcrypt('adminadmin'),
            'emp_id' => 1,
            'role_id' => 1
        ]);
    }
}
