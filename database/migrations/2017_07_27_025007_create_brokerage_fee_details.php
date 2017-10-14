<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageFeeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brokerage_fee_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('minimum', 19, 2);
            $table->decimal('maximum', 19, 2);
            $table->decimal('amount', 19, 2);
            $table->integer('brokerage_fee_headers_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brokerage_fee_headers_id')->references('id')->on('brokerage_fee_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brokerage_fee_details');
    }
}
