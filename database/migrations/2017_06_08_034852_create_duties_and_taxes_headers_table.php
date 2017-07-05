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
            $table->decimal('exchangeRate', 10, 3);
            $table->date('date');
            $table->integer('brokerageServiceOrders_id')->unsigned();
            $table->integer('employees_id_broker')->unsigned();
            $table->timestamps();

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
