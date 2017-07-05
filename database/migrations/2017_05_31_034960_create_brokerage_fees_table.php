<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brokerage_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('minimum', 19, 2);
            $table->decimal('maximum', 19, 2);
            $table->decimal('amount', 19, 2);
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
        Schema::dropIfExists('brokerage_fees');
    }
}
