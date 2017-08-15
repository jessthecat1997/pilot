<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 150)->nullable();
            $table->boolean('withContainer');
            $table->timestamps();
            $table->softDeletes();
        });

         DB::statement("
            INSERT INTO `vehicle_types` (`id`, `name`, `description`,`withContainer`) VALUES 
            (NULL, 'truck', 'Usually truck head with chassis', 0),
            (NULL, 'van', 'Used for delivery of small packages',1)
           
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_types');
    }
}
