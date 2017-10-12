<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageNonContainerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('brokerage_non_container_details', function (Blueprint $table) {
          $table->increments('id');
          $table->string('descriptionOfGoods', 200);
          $table->decimal('cubicMeters', 10, 2);
          $table->decimal('grossWeight', 10, 2);
          $table->integer('lclType_id')->unsigned();
          $table->integer('basis')->unsigned();

          $table->string('supplier', 100)->nullable();
          $table->integer('brok_head_id')->unsigned();

          $table->foreign('basis')->references('id')->on('basis_types');
          $table->foreign('lclType_id')->references('id')->on('lcl_types');
          $table->foreign('brok_head_id')->references('id')->on('brokerage_service_orders');
      });
        //
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
