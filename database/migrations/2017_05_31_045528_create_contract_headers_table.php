<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dateEffective')->nullable();
            $table->date('dateExpiration')->nullable();
            $table->text('specificDetails')->nullable();
            $table->integer('consignees_id')->unsigned();
            $table->integer('quot_head_id')->unsigned()->nullable();
            $table->boolean('isFinalize');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consignees_id')->references('id')->on('consignees');
            $table->foreign('quot_head_id')->references('id')->on('quotation_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_headers');
    }
}
