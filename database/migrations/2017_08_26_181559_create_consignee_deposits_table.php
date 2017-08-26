<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsigneeDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignee_deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 19, 3);
            $table->decimal('currentBalance', 19, 3); 
            $table->string('description', 200)->nullable();
            $table->integer('consignees_id')->unsigned();
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
        Schema::dropIfExists('consignee_deposits');
    }
}
