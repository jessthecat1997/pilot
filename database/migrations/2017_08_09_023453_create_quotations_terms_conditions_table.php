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
        $current_time = DB::table('quotation_terms')
        ->insert(
            array(
                'terms' => '1. 6 Hrs. Free Unloading. <br />2. Foul Trip (Cancel Schedule) 50% - Base on Manila rate Php 14,000.00<br />3. Demurrage 6 to 12 hours upon arrival -50%<br />4. Demurrage 12 hours to 24 hours upon arrival-100%<br />5. Unreturned Container due to QUOTA at the Port -Php 10,000/Day<br />6. Cancellation of Booking; cut off until 3:00PM (shall be in form of email,if no email received, foul trip shall be imposed against ASPAC.)<br />7. Bobtail- 90%<br />8. Back to Back deliveries - Special Rates upon request<br />',
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
