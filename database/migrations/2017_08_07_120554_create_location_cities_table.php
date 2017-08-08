<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationCitiesTable extends Migration
{

    public function up()
    {
        Schema::create('location_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('provinces_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('provinces_id')->references('id')->on('location_provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_cities');
    }
}
