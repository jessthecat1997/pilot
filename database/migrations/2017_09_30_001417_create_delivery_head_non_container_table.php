<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryHeadNonContainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_head_non_containers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('del_head_id')->unsigned();
            $table->integer('non_con_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('del_head_id')->references('id')->on('delivery_receipt_headers');
            $table->foreign('non_con_id')->references('id')->on('delivery_non_container_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_head_non_containers');
    }
}
