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
      $table->text('name');
      $table->string('hsCode', 20);
      $table->decimal('rate', 5 , 2);
      $table->integer('category_types_id')->unsigned();
      $table->timestamps();
      $table->softDeletes();


      $table->foreign('category_types_id')->references('id')->on('category_types');
    });

    DB::statement("

      INSERT INTO `items` (`id`, `name`, `hsCode`, `rate`, `category_types_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'Electric motors and generators, Motors of an output not exceeding 37.5 W, DC motors, Stepper motors, Of a kind used for the goods of heading 84.15, 84.18, 84.50, 85.09 or 85.16', '8501.10.21', '0', '10', NULL, NULL, NULL), (NULL, 'Electric motors and generators, Motors of an output not exceeding 37.5 W, DC motors, Stepper motors, Other of an output not exceeding 5 W', '8501.10.22', '0', '10', NULL, NULL, NULL), (NULL, 'Electric motors and generators, Motors of an output not exceeding 37.5 W, DC motors, Stepper motors, Other', '8501.10.29', '0', '10', NULL, NULL, NULL), (NULL, 'Electric motors and generators, Motors of an output not exceeding 37.5 W, DC motors, Spindle motors', '8501.10.30', '0', '10', NULL, NULL, NULL), (NULL, 'Electric motors and generators, Motors of an output not exceeding 37.5 W, DC motors, Other, Of kind used for the goods of heading 84.15, 84.18,84.50,85.09 or 85.16', '8502.10.41', '0', '10', NULL, NULL, NULL);

      ");
  }

  public function down()
  {
    Schema::dropIfExists('items');
  }
}
