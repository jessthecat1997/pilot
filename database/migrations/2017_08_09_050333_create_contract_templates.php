<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateContractTemplates extends Migration
{
    public function up()
    {
        Schema::create('contract_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        $current_time = DB::table('contract_templates')
        ->insert(
            array(
                'name' => 'template',
                'description' => 
                '
                1. The FIRST PARTY may engage the trucking services of the SECOND PARTY on a per trip  whenever exigencies require. This engagement is independent of any other agreement which may
                exists or has been previously executed between parties. <br/>
                2 Prior to signing this Hauling Agreement, the SECOND PARTY shall submit to the FIRST
                PARTY the "Standard Accreditation Requirements". The SECOND PARTY commits that said
                requirements shall be accordingly updated or renewed when the need arises without need of demand
                from the FIRST PARTY.<br/>
                3 The SECOND PARTY commits that any and all trucks to be used in servicing the hauling needs
                of the FIRST PARTY shall be clean and in good running condition to ensure the safe and timely
                delivery / pick-up of cargoes. <br/>
                4 The SECOND PARTY shall assign one (1) driver and one (1) helper for each truck deployed to
                the FIRST PARTY. The SECOND PARTY shall ensure that the driver and helper thus deployed 
                are neat in appearance. They must be in their proper uniform whenever servicing the hauling needs of
                the FIRST PARTY. Under no circumstances shall the SECOND PARTY deploy personnel wearing
                shorts, sando and / or slippers. SECOND PARTY is considered and independent contractor. Neither
                party is legal representative or agent of, or has the power to obligate the other for any purpose
                whatsoever. Both parties expressly acknowledge that the relationship intended by them is a business
                relationship based on, and defined by, the express provisions of the Agreement, and that no
                partnership, joint venture, affiliate, agency, or fiduciary relationship is intended or created by reason
                this Agreement. <br/>
                5 Drivers and helpers shall be and remain SECOND PARTYs own employees and such employees
                will never be treated in anyway as FIRST PARTYs employees. In event that any of SECOND
                PARTYs employees assigned to FIRST PARTYs shall be awarded any labor-related claims
                against FIRST PARTY, SECOND PARTY shall shoulder and pay for the same.
                In the fulfillment of its obligations under this Agreement SECOND PARTY shall select and hire its
                drivers and helpers assigned to FIRST PARTY. SECOND PARTY alone shall be responsible for the payment of their wages and other employment benefits and likewise for the safeguard of their health and safety in accordance with existing laws and regulation. 
                Likewise, SECOND PARTY shall be responsible for the discipline and/or dismissal of these personnel as well as be liable for damages or injuries caused by the third party.
                It is understood that for the above reasons, these personnel shall be considered as sole employees of SECOND PARTY.<br/>
                6 The SECOND PARTY warrants that any and all drivers and helpers manning the trucks deployed to the FIRST PARTY have undergone drug-testing and are cleared with NBI and PNP. The
                SECOND PARTY likewise commits to conduct an annual drug testing of the drivers and helpers
                thus mentioned.<br/>
                7 The SECOND PARTY shall, at its own expense, adhere to the freight security guidelines and
                cargo/document handling procedures implemented by the FIRST PARTY or its customers. This
                includes, but is not limited to the provision of sturdy padlocks, chokes, early warning device, fire
                extinguisher, nylon ropes, flashlights, standard tool kit, etc.<br/>
                8 As an added security measure, the SECOND PARTY shall provide any and all trucks deployed to the FIRST PARTY with sufficient communication equipment such as cellular phones and GPS.<br/>
                9 All repairs and maintenance expenses of the trucks shall be for the account of the SECOND PARTY. Toll fees, parking fees and other related expenses shall likewise be shouldered by the SECOND PARTY.<br/>
                0 For its services, the FIRST PARTY shall accordingly pay the sum equivalent to the agreed rates on a per trip, per truck basis to the SECOND PARTY as stipulated in ANNEX"A". Demurrage fees
                may be agreed upon by the parties. <br/>
                1 The SECOND PARTY shall not affect any increase in trucking rate unless the same has been
                mutually agreed upon by both parties. Provided, however, that such agreement has been reduced to
                the writing prior to the effectivity of said increase. <br/>
                2 Payment shall be made by the FIRST PARTY to the SECOND PARTY within Fifteen (15)
                days upon receipt of the billing statement. The billing statement shall be submitted by the SECOND
                PARTY within three (3) working days after rendition of service. Otherwise, a 5% penalty of the total
                billing will be imposed in case of late billings. If the SECOND PARTY already violated the 3rd
                time, 10% penalty will be imposed. <br/>
                ',
                'created_at' => Carbon::now()->toDayDateTimeString(),
                'updated_at' => Carbon::now()->toDayDateTimeString()
                )
);
}


public function down()
{
    Schema::dropIfExists('contract_templates');
}
}
