<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrderAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_order_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('so_head_id')->unsigned();
            $table->text('file_path');
            $table->integer('req_type_id')->unsigned();
            $table->text('description');
            $table->softDeletes();

            $table->foreign('so_head_id')->references('id')->on('consignee_service_order_headers');
            $table->foreign('req_type_id')->references('id')->on('requirements');
        });
    }
    public function down()
    {
        Schema::dropIfExists('service_order_attachments');
    }
}
