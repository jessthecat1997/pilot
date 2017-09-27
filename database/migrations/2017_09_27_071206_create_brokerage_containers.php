<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageContainers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('brokerage_containers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('containerNumber', 15);
          $table->string('containerVolume', 4);
          $table->string('shippingLine', 100)->nullable();
          $table->string('portOfCfsLocation', 100)->nullable();
          $table->string('containerReturnTo', 200);
          $table->text('containerReturnAddress', 300);
          $table->dateTime('containerReturnDate');
          $table->char('containerReturnStatus', 1);
          $table->dateTime('dateReturned')->nullable();
          $table->string('remarks', 200);
          $table->integer('brok_so_id')->unsigned();

          $table->foreign('brok_so_id')->references('id')->on('brokerage_service_orders');
         });//
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
