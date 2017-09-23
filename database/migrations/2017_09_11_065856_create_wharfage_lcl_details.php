<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWharfageLclDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wharfage_lcl_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wharfage_lcl_headers_id')->unsigned();
            $table->integer('basis_types_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('wharfage_lcl_headers_id')->references('id')->on('wharfage_lcl_headers');
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
        Schema::dropIfExists('wharfage_lcl_details');
    }
}
