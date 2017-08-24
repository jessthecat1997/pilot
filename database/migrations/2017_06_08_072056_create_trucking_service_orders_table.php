<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckingServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucking_service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('status', 1);
            $table->integer('so_details_id')->unsigned();
            $table->integer('bi_head_id_rev')->unsigned()->nullable();
            $table->integer('bi_head_id_exp')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('so_details_id')->references('id')->on('consignee_service_order_details');
            $table->foreign('bi_head_id_rev')->references('id')->on('billing_invoice_headers');
            $table->foreign('bi_head_id_exp')->references('id')->on('billing_invoice_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trucking_service_orders');
    }
}
