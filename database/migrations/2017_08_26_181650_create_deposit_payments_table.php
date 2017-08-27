<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deposits_id')->unsigned();
            $table->integer('bi_head_id')->unsigned();
            $table->string('description', 250)->nullable();
            $table->decimal('amount', 19, 3);
            $table->timestamps();

            $table->foreign('deposits_id')->references('id')->on('consignee_deposits');
            $table->foreign('bi_head_id')->references('id')->on('billing_invoice_headers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_payments');
    }
}
