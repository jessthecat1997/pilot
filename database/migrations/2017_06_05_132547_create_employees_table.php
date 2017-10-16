<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName', 100);
            $table->string('middleName', 100)->nullable();
            $table->string('lastName', 100);
            $table->date('dob');
            $table->text('address')->nullable();
            $table->string('zipCode', 5)->nullable();
            $table->integer('cities_id')->unsigned()->nullable();
            $table->string('SSSNo', 20)->nullable();
            $table->string('contactNumber');
            $table->string('inCaseOfEmergency', 400);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cities_id')->references('id')->on('location_cities');
        });

        DB::statement("
            INSERT INTO `employees` (`id`, `firstName`, `middleName`, `lastName`, `dob`, `address`, `zipCode`, `cities_id`, `SSSNo`, `contactNumber`, `inCaseOfEmergency`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'admin', NULL, 'admin', '', 'admin address', '1111', '324', '1111', '0935322655', 'call the number', NULL, NULL, NULL);
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
