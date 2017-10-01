<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{

    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('hsCode', 20);
            $table->decimal('rate', 5 , 2);
            $table->integer('sections_id')->unsigned();
            $table->integer('category_types_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sections_id')->references('id')->on('sections');
            $table->foreign('category_types_id')->references('id')->on('category_types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
