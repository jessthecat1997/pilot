<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignee_service_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('so_headers_id')->unsigned();
            $table->integer('service_order_types_id')->unsigned();
            $table->timestamps();

            $table->foreign('so_headers_id')->references('id')->on('consignee_service_order_headers');
            $table->foreign('service_order_types_id')->references('id')->on('service_order_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignee_service_order_details');
    }
}
