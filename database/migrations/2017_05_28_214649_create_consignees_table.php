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
            $table->string('middleName', 45);
            $table->string('lastName', 45);
            $table->string('companyName', 250);
            $table->string('email', 100);
            $table->text('address');
            $table->string('contactNumber', 30);
            $table->boolean('consigneeType');
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