<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'firstName' => 'Admin',
            'middleName' => 'admin',
            'lastName' => 'Admin',
            'dob' => '2000-01-01',
            'address' => 'Pasig',
            'zipCode' => '2121',
            'cities_id' => 1,
            'SSSNo' => 'adasas',
            'contactNumber' => '021913112',
            'inCaseOfEmergency' => 'dasdad'
        ]);
    }
}
