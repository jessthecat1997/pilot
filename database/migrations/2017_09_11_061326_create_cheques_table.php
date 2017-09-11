 <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('isVerify');
            $table->integer('bi_head_id')->unsigned();
            $table->timestamps();

            $table->foreign('bi_head_id')->references('id')->on('billing_invoice_headers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('cheques');
    }
}
