<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDutiesAndTaxesHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duties_and_taxes_headers', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('exchangeRate_id')->unsigned();
          $table->integer('cdsFee_id')->unsigned();
          $table->integer('ipfFee_id')->unsigned();
          $table->integer('brokerageFee');
          $table->decimal('arrastre', 19, 2);
          $table->decimal('wharfage', 19, 2);
          $table->decimal('bankCharges', 19, 2);

          $table->date('date');
          $table->integer('brokerageServiceOrders_id')->unsigned();
          $table->integer('employees_id_broker')->unsigned();
          $table->timestamps();

          $table->foreign('exchangeRate_id')-> references('id')->on('exchange_rates');
          $table->foreign('cdsFee_id')-> references('id')->on('cds_fees');
          $table->foreign('ipfFee_id')-> references('id')->on('import_processing_fee_headers');

          $table->foreign('brokerageServiceOrders_id')-> references('id')->on('brokerage_service_orders');
          $table->foreign('employees_id_broker')->references('id')->on('employees');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duties_and_taxes_headers');
    }
}
