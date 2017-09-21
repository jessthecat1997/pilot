<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateAccidentsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_accidents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employees_id')->unsigned();
            $table->date('incident_date');
            $table->time('incident_time');
            $table->date('date_opened');
            $table->date('date_closed')->nullable();
            $table->text('address')->nullable();
            $table->integer('cities_id')->nullable();
            $table->integer('delivery_id')->nullable();
            $table->integer('numberOfInjuries');
            $table->integer('numberOfFatalities');
            $table->decimal('propertyDamage', 19, 2)->nullable();
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employees_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_accidents');
    }
}
