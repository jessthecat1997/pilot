<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTypesTable extends Migration
{

    public function up()
    {
        Schema::create('category_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('sections_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sections_id')->references('id')->on('sections');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_types');
    }
}
