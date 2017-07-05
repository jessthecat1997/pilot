<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDutiesAndTaxesDetailsTable extends Migration
{
   
    public function up()
    {
        Schema::create('duties_and_taxes_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descriptionOfGoods',100);
            $table->decimal('valueInUSD',19, 3);
            $table->decimal('insurance',19, 3);
            $table->decimal('freight',19, 3);
            $table->decimal('otherCharges', 19, 3);
            $table->string ('hsCode',20);
            $table->decimal ('rateOfDuty',3, 2);
            $table->integer('dutiesAndTaxesHeaders_id')->unsigned();
            $table->timestamps();

            $table->foreign('dutiesAndTaxesHeaders_id')->references('id')->on('duties_and_taxes_headers');
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('duties_and_taxes_details');
    }
}
