<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundableChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refundable_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 50);
            $table->decimal('amount', 19, 2);
            $table->integer('charges_id')->unsigned();
            $table->integer('so_head_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('charges_id')->references('id')->on('charges');
            $table->foreign('so_head_id')->references('id')->on('consignee_service_order_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refundable_charges');
    }
}
