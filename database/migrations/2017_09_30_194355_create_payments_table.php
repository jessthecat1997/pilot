<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount',19,2);
            $table->text('description')->nullable();
            $table->boolean('isCheque');
            $table->integer('bi_head_id')->unsigned();
            $table->integer('utility_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bi_head_id')->references('id')->on('billing_invoice_headers');
            $table->foreign('utility_id')->references('id')->on('utility_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
