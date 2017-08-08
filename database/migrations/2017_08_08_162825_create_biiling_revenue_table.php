<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiilingExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_revenues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 200)
            $table->decimal('amount',10,2);
            $table->decimal('tax', 2,2);
            $table->integer('bill_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bill_id')->references('id')->on('billings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('billing_revenues');
    }
    }
}
