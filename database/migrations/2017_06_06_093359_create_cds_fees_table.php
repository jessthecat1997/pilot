<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdsFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cds_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('fee', 10, 2);
            $table->boolean('currentFee');
            $table->date('dateEffective');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('INSERT INTO cds_fees (`fee`, `currentFee`, `dateEffective`, `created_at`, `updated_at`) VALUES (225.00, 1, NOW(), NOW(), NOW())');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cds_fees');
    }
}
