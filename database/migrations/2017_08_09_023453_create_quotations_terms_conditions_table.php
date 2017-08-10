<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateQuotationsTermsConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->text('terms');
            $table->timestamps();
            $table->softDeletes();
        });
        $current_time = 
        DB::table('quotation_terms')
        ->insert(
            array(
                'terms' => '6 Hrs. Free Unloading.',
                'created_at' => Carbon::now()->toDayDateTimeString(),
                'updated_at' => Carbon::now()->toDayDateTimeString()
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_terms');
    }
}
