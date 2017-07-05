<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryContainers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_containers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('containerNumber', 11);
            $table->string('containerVolume', 4);
            $table->string('containerReturnTo', 200);
            $table->text('containerReturnAddress', 300);
            $table->dateTime('containerReturnDate');
            $table->char('containerReturnStatus', 1);
            $table->dateTime('dateReturned')->nullable();
            $table->string('remarks', 200);
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
        Schema::dropIfExists('delivery_containers');
    }
}
