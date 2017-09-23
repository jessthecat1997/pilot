<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrastreFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('arrastre_fees', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('location_id')->unsigned();
        $table->integer('container_type_id')->unsigned();
        $table->integer('cargo_types_id')->unsigned();
        $table->string('classification', 1);
        $table->decimal('amount', 10, 2);
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('cargo_types_id')->references('id')->on('cargo_types');
        $table->foreign('location_id')->references('id')->on('locations');
        $table->foreign('container_type_id')->references('id')->on('container_types');

      });        //
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
