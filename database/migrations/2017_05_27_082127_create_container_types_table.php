<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerTypesTable extends Migration
{
    
    public function up()
    {
        Schema::create('container_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->decimal('maxWeight', 9, 2);
            $table->string('description', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("
            INSERT INTO `container_types` (`id`, `name`, `maxWeight`) VALUES
             (NULL, '10-footer', '11300'),
             (NULL, '20-footer', '30480'),
             (NULL, '40-footer', '30400')
            ");

    }

   
    public function down()
    {
        Schema::dropIfExists('container_types');
    }
}
