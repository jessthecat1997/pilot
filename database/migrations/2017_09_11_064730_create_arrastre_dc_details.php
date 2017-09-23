<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrastreDcDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrastre_dc_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('arrastre_dc_headers_id')->unsigned();
            $table->integer('container_sizes_id')->unsigned();
            $table->integer('dc_types_id')->unsigned();
            $table->decimal('amount' , 10, 2);
            $table->timestamps();
            $table->softDeletes();
             $table->foreign('container_sizes_id')->references('id')->on('container_types');
            $table->foreign('arrastre_dc_headers_id')->references('id')->on('arrastre_dc_headers');
            $table->foreign('dc_types_id')->references('id')->on('dangerous_cargo_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrastre_dc_details');
    }
}
