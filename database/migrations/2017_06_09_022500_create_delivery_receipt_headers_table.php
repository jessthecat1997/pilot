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
            $table->integer('emp_id_helper')->unsigned();
            $table->text('deliveryAddress', 200)->nullable();
            $table->string('plateNumber', 20);
            $table->boolean('withContainer');
            $table->char('status', 1);
            $table->decimal('amount', 19, 2, 0);
            $table->string('remarks', 200)->nullable();
            $table->integer('tr_so_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emp_id_driver')->references('id')->on('employees');
            $table->foreign('emp_id_helper')->references('id')->on('employees');
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
