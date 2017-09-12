<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrastreLclDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrastre_lcl_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('arrastre_lcl_headers_id')->unsigned();
            $table->integer('lcl_types_id')->unsigned();
            $table->integer('basis_types_id')->unsigned();
            $table->decimal('amount' , 10, 2);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('arrastre_lcl_headers_id')->references('id')->on('arrastre_lcl_headers');
             $table->foreign('lcl_types_id')->references('id')->on('lcl_types');
            $table->foreign('basis_types_id')->references('id')->on('basis_types');
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
