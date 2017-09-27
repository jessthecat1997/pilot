<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportProcessingFeeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_processing_fee_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('minimum', 19, 2);
            $table->decimal('maximum', 19, 2);
            $table->decimal('amount', 19, 2);
            $table->integer('ipf_headers_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ipf_headers_id')->references('id')->on('import_processing_fee_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_processing_fee_details');
    }
}
