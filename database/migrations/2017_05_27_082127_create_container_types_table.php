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
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("
            INSERT INTO `container_types` (`id`, `name`, `maxWeight`) VALUES
             (NULL, '20', '30480'),
             (NULL, '40', '30400'),
             (NULL, '45', '30800')
            ");

    }

   
    public function down()
    {
        Schema::dropIfExists('container_types');
    }
}
