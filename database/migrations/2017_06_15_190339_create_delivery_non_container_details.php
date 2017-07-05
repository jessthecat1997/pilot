<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryNonContainerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_non_container_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descriptionOfGoods', 200);
            $table->decimal('grossWeight', 10, 2);
            $table->string('supplier', 100)->nullable();
            $table->integer('del_head_id')->unsigned();

            $table->foreign('del_head_id')->references('id')->on('delivery_receipt_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_non_container_details');
    }
}
