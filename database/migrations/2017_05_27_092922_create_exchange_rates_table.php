<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->decimal('rate', 10, 7);
            $table->boolean('currentRate');
            $table->date('dateEffective');
            $table->timestamps();
            $table->softDeletes();

        });

        DB::statement('INSERT INTO exchange_rates (`rate`, `currentRate`, `dateEffective`, `created_at`, `updated_at`) VALUES (47.777, 1, NOW(), NOW(), NOW())');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rates');
    }
}
