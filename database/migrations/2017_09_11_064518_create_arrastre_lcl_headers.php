<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrastreLclHeaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrastre_lcl_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('locations_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('locations_id')->references('id')->on('locations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrastre_lcl_headers');
    }
}
