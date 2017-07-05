<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpfFeesTable extends Migration
{
    
    public function up()
    {
        Schema::create('ipf_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('minimum', 10, 2);
            $table->decimal('maximum', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipf_Fees');
    }
}
