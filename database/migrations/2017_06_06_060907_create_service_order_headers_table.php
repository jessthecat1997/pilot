<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignee_service_order_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('consignees_id')->unsigned();
            $table->integer('employees_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consignees_id')->references('id')->on('consignees');
            $table->foreign('employees_id')->references('id')->on('employees');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignee_service_order_headers');
    }
}
