<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageContainerDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('brokerage_container_details', function (Blueprint $table) {
          $table->increments('id');
          $table->string('descriptionOfGoods', 200);
          $table->integer('class_id')->unsigned()->nullable();
          $table->decimal('grossWeight', 10, 2);
          $table->string('supplier', 100)->nullable();
          $table->integer('container_id')->unsigned();

          $table->foreign('class_id')->references('id')->on('dangerous_cargo_types');
          $table->foreign('container_id')->references('id')->on('brokerage_containers');
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
