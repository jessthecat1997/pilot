<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBilledRevenues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('order_billed_revenues', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('order_brokerage_id')->unsigned();
          $table->integer('bi_head_id')->unsigned();
          $table->timestamps();

          $table->foreign('order_brokerage_id')->references('id')->on('duties_and_taxes_headers');
          $table->foreign('bi_head_id')->references('id')->on('billing_invoice_details');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
