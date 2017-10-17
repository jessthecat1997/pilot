<?php

use Illuminate\Database\Seeder;

class EmployeeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_types')->insert([
        [
        'name' => 'Admin'
        ],
        [
        'name' => 'Broker'
        ],
        [
        'name' => 'Trucking Manager'
        ],
        [
        'name' => 'Billing Manager'
        ],
        [
        'name' => 'Driver'
        ],
        [
        'name' => 'Helper'
        ]
        ]);
 }
}
