<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWharfageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wharfage_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wharfage_header_id')->unsigned();
            $table->integer('container_sizes_id')->unsigned();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('wharfage_header_id')->references('id')->on('wharfage_headers');
            $table->foreign('container_sizes_id')->references('id')->on('container_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wharfage_details');
    }
}
