<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryHeadContainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliviery_head_containers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('del_head_id')->unsigned();
            $table->integer('container_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('del_head_id')->references('id')->on('delivery_receipt_headers');
            $table->foreign('container_id')->references('id')->on('delivery_containers');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliviery_head_containers');
    }
}
