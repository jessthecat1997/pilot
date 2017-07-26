<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractAmendmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_amendments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amendment', 250);
            $table->integer('contract_headers_id')->unsigned();
            $table->timestamps();

            $table->foreign('contract_headers_id')->references('id')->on('contract_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_amendments');
    }
}
