<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('plateNumber',20);
            $table->string('model',100);
            $table->string('bodyType',100);
            $table->date('dateRegistered');
            $table->integer('vehicle_types_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('plateNumber');
            $table->foreign('vehicle_types_id')->references('id')->on('vehicle_types');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
