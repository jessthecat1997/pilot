<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryContainerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_container_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descriptionOfGoods', 200);
            $table->decimal('grossWeight', 10, 2);
            $table->string('supplier', 100)->nullable();
            $table->integer('container_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('delivery_container_details');
    }
}
