<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName', 45);
            $table->string('middleName', 45)->nullable();
            $table->string('lastName', 45);
            $table->string('companyName', 250);
            $table->string('email', 100);
            $table->string('address', 100);
            $table->string('city', 100);
            $table->string('st_prov', 100);
            $table->string('zip', 10);
            $table->string('b_address', 100);
            $table->string('b_city', 100);
            $table->string('b_st_prov', 100);
            $table->string('b_zip', 10);
            $table->text('billing_address');
            $table->string('contactNumber', 30);
            $table->string('businessStyle', 100);
            $table->string('TIN', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignees');
    }
}