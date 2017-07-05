<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('areas_id_from')->unsigned();
            $table->integer('areas_id_to')->unsigned();
            $table->decimal('amount', 19, 2);
            $table->boolean('currentRate');
            $table->integer('contract_headers_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('areas_id_from')->references('id')->on('areas');
            $table->foreign('areas_id_to')->references('id')->on('areas');
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
        Schema::dropIfExists('contract_details');
    }
}
