<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardAreaRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_area_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('areaTo')->unsigned();
            $table->integer('areaFrom')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('areaTo')->references('id')->on('locations');
            $table->foreign('areaFrom')->references('id')->on('locations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standard_area_rate_headers');
    }
}
