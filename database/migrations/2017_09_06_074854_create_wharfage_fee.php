<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWharfageFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('wharfage_fees', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('location_id')->unsigned();
        $table->decimal('amount', 10, 2);
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('location_id')->references('id')->on('locations');
      });
        
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
