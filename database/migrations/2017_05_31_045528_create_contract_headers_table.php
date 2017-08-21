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
            $table->boolean('isFinalize');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consignees_id')->references('id')->on('consignees');
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
