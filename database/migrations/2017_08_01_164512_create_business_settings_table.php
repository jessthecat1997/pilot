<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('com_name', 100);
            $table->string('com_image', 100)->nullable();
            $table->string('com_owner_firstName', 50);
            $table->string('com_owner_middleName', 50)->nullable();
            $table->string('com_owner_lastName', 50);
            $table->string('com_address_roomUnitStall', 100);
            $table->string('com_address_buildingFloor', 50);
            $table->string('com_address_buildingName', 100);
            $table->string('com_address_lotHouseNo', 50);
            $table->string('com_address_street', 100);
            $table->string('com_address_subdivision', 100);
            $table->string('com_address_barangay', 100);
            $table->string('com_address_province', 100);
            $table->string('com_address_city', 100);
            $table->string('com_address_zipCode', 20);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_settings');
    }
}
