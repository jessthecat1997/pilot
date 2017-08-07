<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationZipsTable extends Migration
{


    public function up()
    {
        Schema::create('location_zips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zipCode', 5);
            $table->integer('cities_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cities_id')->references('id')->on('location_cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_zips');
    }
}
