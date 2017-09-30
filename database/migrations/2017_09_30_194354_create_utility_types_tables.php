<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilityTypesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_types', function (Blueprint $table) {
            $table->increments('id');
            $table->text('contract_template');
            $table->text('quotation_template');
            $table->decimal('bank_charges', 6, 2);
            $table->decimal('other_charges', 6,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utility_types');
    }
}
