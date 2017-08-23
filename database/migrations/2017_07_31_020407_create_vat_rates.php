<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVatRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 150)->nullable();
            $table->decimal('rate', 10 , 7);
            $table->boolean('currentRate');
            $table->date('dateEffective');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('INSERT INTO vat_rates (`rate`, `currentRate`, `dateEffective`, `created_at`, `updated_at`) VALUES (12.0, 1, NOW(), NOW(), NOW())');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vat_rates');
    }
}
