<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount',19,2);
            $table->integer('so_head_id')->unsigned();
            $table->integer('payment_mode_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('so_head_id')->references('id')->on('consignee_service_order_headers');
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
