<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrastreDcHeaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrastre_dc_headers', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('locations_id')->unsigned();
             $table->date('dateEffective');
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
        Schema::dropIfExists('arrastre_dc_headers');
    }
}
