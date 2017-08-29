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
        $table->decimal('deposit', 19, 2);
        $table->string('shipper', 200);
        $table->date('expectedArrivalDate');
        $table->date('arrivalDate');
        $table->integer('location_id')->unsigned();
        $table->string('freightType', 30);
        $table->string('freightBillNo', 30);
        $table->decimal('Weight', 15, 2);
        $table->string('statusType', 1);
        $table->integer('consigneeSODetails_id')->unsigned();
        $table->integer('bi_head_id_rev')->unsigned()->nullable();
        $table->integer('bi_head_id_exp')->unsigned()->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('consigneeSODetails_id')-> references('id')->on('consignee_service_order_details');
        $table->foreign('location_id')->references('id')->on('locations');
        $table->foreign('bi_head_id_rev')->references('id')->on('billing_invoice_headers');
        $table->foreign('bi_head_id_exp')->references('id')->on('billing_invoice_headers');
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
