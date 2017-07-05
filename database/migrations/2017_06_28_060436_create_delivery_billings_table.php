<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('charges_id')->unsigned();
            $table->decimal('amount', 19, 2);
            $table->boolean('isBilled');
            $table->boolean('isBilledTo');
            $table->string('remarks', 100)->nullable();
            $table->integer('del_head_id')->unsigned();
            $table->timestamps();

            $table->foreign('del_head_id')->references('id')->on('delivery_receipt_headers');
            $table->foreign('charges_id')->references('id')->on('charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_billings');
    }
}
