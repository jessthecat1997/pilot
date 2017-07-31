<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardAreaRateDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_area_rate_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('standard_area_rate_headers_id')->unsigned();
             $table->decimal('amount', 19, 2);
            $table->timestamps();

            $table->foreign('standard_area_rate_headers_id')->references('id')->on('standard_area_rate_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standard_area_rate_details');
    }
}
