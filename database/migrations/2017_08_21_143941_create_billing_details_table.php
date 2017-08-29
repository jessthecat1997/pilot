<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingDetailsTable extends Migration
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
            $table->string('description', 200)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('tax', 2, 2);
            $table->integer('charge_id')->unsigned();
            $table->integer('bi_head_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('charge_id')->references('id')->on('charges');
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
        Schema::dropIfExists('billing_invoice_details');
    }
}
