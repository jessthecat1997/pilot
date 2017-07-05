<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_invoice_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 19, 3);
            $table->decimal('discount', 3, 2);
            $table->integer('billings_id')->unsigned();
            $table->integer('bi_head_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bi_head_id')->references('id')->on('billing_invoice_headers');
            $table->foreign('billings_id')->references('id')->on('billings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_invoice_details');
    }
}
