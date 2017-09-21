<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryReceiptHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_receipt_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id_driver')->unsigned();
            $table->integer('emp_id_helper')->unsigned()->nullable();
            
            $table->integer('locations_id_pick')->unsigned();
            $table->integer('locations_id_del')->unsigned();

            $table->string('plateNumber', 20);
            $table->boolean('withContainer');
            $table->char('status', 1);
            $table->decimal('amount', 19, 2, 0);
            $table->dateTime('deliveryDateTime');
            $table->dateTime('pickupDateTime');
            $table->dateTime('cancelDateTime')->nullable();
            $table->string('remarks', 200)->nullable();
            $table->integer('tr_so_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emp_id_driver')->references('id')->on('employees');
            $table->foreign('emp_id_helper')->references('id')->on('employees');

            $table->foreign('locations_id_pick')->references('id')->on('locations');
            $table->foreign('locations_id_del')->references('id')->on('locations');

            $table->foreign('plateNumber')->references('plateNumber')->on('vehicles');
            $table->foreign('tr_so_id')->references('id')->on('trucking_service_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_receipt_headers');
    }
}
