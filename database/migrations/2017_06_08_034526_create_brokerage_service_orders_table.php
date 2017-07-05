<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brokerage_service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('expectedArrivalDate');
            $table->date('arrivalDate');
            $table->string('supplier',50);
            $table->decimal('deposit', 19, 2);
            $table->string('containerNumber', 11);
            $table->integer('containerType_id')->unsigned();
            $table->string('statusType', 1);
            $table->string('receiveTypeDescription', 20);
            $table->boolean('awbType');
            $table->string('awb', 200);
            $table->string('billOfLading', 30);
            $table->string('vessel', 200);
            $table->string('docking', 200);
            $table->integer('consigneeSODetails_id')->unsigned();
            $table->timestamps();


            $table->foreign('consigneeSODetails_id')-> references('id')->on('consignee_service_order_details');
            $table->foreign('containerType_id')-> references('id')->on('container_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brokerage_service_orders');
    }
}
