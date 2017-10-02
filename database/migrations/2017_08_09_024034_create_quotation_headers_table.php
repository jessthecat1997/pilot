<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('consignees_id')->unsigned();
            $table->text('specificDetails')->nullable();
            $table->integer('quot_head_id')->unsigned()->nullable();
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
        Schema::dropIfExists('quotation_headers');
    }
}
