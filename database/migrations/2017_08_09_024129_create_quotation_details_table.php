<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('locations_id_from')->nullable()->unsigned();
            $table->integer('locations_id_to')->nullable()->unsigned();
            $table->decimal('amount', 19, 2);
            $table->integer('quot_header_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('locations_id_from')->references('id')->on('locations');
            $table->foreign('locations_id_to')->references('id')->on('locations');
            $table->foreign('quot_header_id')->references('id')->on('quotation_headers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_details');
    }
}
