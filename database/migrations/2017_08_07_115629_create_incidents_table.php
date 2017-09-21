<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateIncidentsTable extends Migration
{

    public function up()
    {
        Schema::create('employee_incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employees_id')->unsigned();
            $table->date('incident_date');
            $table->time('incident_time');
            $table->date('date_opened');
            $table->date('date_closed')->nullable();
            $table->text('address')->nullable();
            $table->integer('cities_id')->unsigned()->nullable();
            $table->integer('delivery_id')->unsigned()->nullable();
            $table->decimal('fine', 19, 2)->nullable();
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employees_id')->references('id')->on('employees');
            $table->foreign('cities_id')->references('id')->on('location_cities');
            $table->foreign('delivery_id')->references('id')->on('delivery_receipt_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_incidents');
    }
}
