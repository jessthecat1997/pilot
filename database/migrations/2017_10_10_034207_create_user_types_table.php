<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("
            INSERT INTO `user_types` (`id`, `name`) VALUES 
            (NULL, 'Admin'),
            (NULL, 'Broker'),
            (NULL, 'Trucking Manager'),
            (NULL, 'Billing Manager')
            
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_types');
    }
}
