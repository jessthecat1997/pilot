<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingInvoiceHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_invoice_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paymentAllowance');
            $table->integer('so_head_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('billing_invoice_headers');
    }
}
