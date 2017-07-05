<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsigneeContactPersonsTable extends Migration
{
    public function up()
    {
        Schema::create('consignee_contact_persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName', 45);
            $table->string('middleName', 45);
            $table->string('lastName', 45);
            $table->integer('consignees_id')->unsigned();
            $table->timestamps();


            $table->foreign('consignees_id')->references('id')->on('consignees');

        });
    }

  
    public function down()
    {
        Schema::dropIfExists('consignee_contact_persons');
    }
}
