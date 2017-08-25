<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('employee_details', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('employees_id')->unsigned();
        $table->date('dateOfBirth');
        $table->integer('age');
        $table->string('address', 100)->nullable();
        $table->string('zipCode', 5)->nullable();
        $table->integer('cities_id')->unsigned()->nullable();
        $table->integer('socialSecurityNumber');
        $table->string('cellphoneContact');
        $table->string('phoneContact');
        $table->integer('emergencyContact');
        $table->string('inCaseOfEmergency', 400);

        $table->timestamps();
        $table->softDeletes();

        $table->foreign('cities_id')->references('id')->on('location_cities');
       $table->foreign('employees_id')->references('id')->on('employees');

    });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
