<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderTypesTable extends Migration
{
   
    public function up()
    {
        Schema::create('service_order_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 150)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("
            INSERT INTO `service_order_types` (`id`, `name`, `description`) VALUES 
            (NULL, 'Brokerage', 'A profession that involves the clearing of documents for discharge or release  of goods through  the Bureau of Customs '),
            (NULL, 'Trucking', 'A profession that  involves in the process or business of conveying goods on trucks.'),
            (NULL, 'Brokerage and Trucking', 'Customs brokerage with trucking service')
            
            ");
    }

    
    public function down()
    {
        Schema::dropIfExists('service_order_types');
    }
}
