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
                '1. The FIRST PARTY may engage the trucking services of the SECOND PARTY on a per trip  whenever exigencies require. This engagement is independent of any other agreement which may 
                exists or has been previously executed between parties. <br/> 2 Prior to signing this Hauling Agreement, the SECOND PARTY shall submit to the FIRST 
                PARTY the "Standard Accreditation Requirements". The SECOND PARTY commits that said 
                requirements shall be accordingly updated or renewed when the need arises without need of demand 
                from the FIRST PARTY.<br/> 3 The SECOND PARTY commits that any and all trucks to be used in servicing the hauling needs 
                of the FIRST PARTY shall be clean and in good running condition to ensure the safe and timely 
                delivery / pick-up of cargoes. <br/> 4 The SECOND PARTY shall assign one (1) driver and one (1) helper for each truck deployed to 
                the FIRST PARTY. The SECOND PARTY shall ensure that the driver and helper thus deployed  
                are neat in appearance. They must be in their proper uniform whenever servicing the hauling needs of 
                the FIRST PARTY. Under no circumstances shall the SECOND PARTY deploy personnel wearing 
                shorts, sando and / or slippers. SECOND PARTY is considered and independent contractor. Neither 
                party is legal representative or agent of, or has the power to obligate the other for any purpose 
                whatsoever. Both parties expressly acknowledge that the relationship intended by them is a business 
                relationship based on, and defined by, the express provisions of the Agreement, and that no 
                partnership, joint venture, affiliate, agency, or fiduciary relationship is intended or created by reason 
                this Agreement. <br/> 5 Drivers and helpers shall be and remain SECOND PARTYs own employees and such employees 
                will never be treated in anyway as FIRST PARTYs employees. In event that any of SECOND 
                PARTYs employees assigned to FIRST PARTYs shall be awarded any labor-related claims 
                against FIRST PARTY, SECOND PARTY shall shoulder and pay for the same. 
                In the fulfillment of its obligations under this Agreement SECOND PARTY shall select and hire its 
                drivers and helpers assigned to FIRST PARTY. SECOND PARTY alone shall be responsible for the payment of their wages and other employment benefits and likewise for the safeguard of their health and safety in accordance with existing laws and regulation.  
                Likewise, SECOND PARTY shall be responsible for the discipline and/or dismissal of these personnel as well as be liable for damages or injuries caused by the third party. 
                It is understood that for the above reasons, these personnel shall be considered as sole employees of SECOND PARTY.<br/> 6 The SECOND PARTY warrants that any and all drivers and helpers manning the trucks deployed to the FIRST PARTY have undergone drug-testing and are cleared with NBI and PNP. The 
                SECOND PARTY likewise commits to conduct an annual drug testing of the drivers and helpers 
                thus mentioned.<br/> 7 The SECOND PARTY shall, at its own expense, adhere to the freight security guidelines and 
                cargo/document handling procedures implemented by the FIRST PARTY or its customers. This 
                includes, but is not limited to the provision of sturdy padlocks, chokes, early warning device, fire 
                extinguisher, nylon ropes, flashlights, standard tool kit, etc.<br/> 8 As an added security measure, the SECOND PARTY shall provide any and all trucks deployed to the FIRST PARTY with sufficient communication equipment such as cellular phones and GPS.<br/> 9 All repairs and maintenance expenses of the trucks shall be for the account of the SECOND PARTY. Toll fees, parking fees and other related expenses shall likewise be shouldered by the SECOND PARTY.<br/> 0 For its services, the FIRST PARTY shall accordingly pay the sum equivalent to the agreed rates on a per trip, per truck basis to the SECOND PARTY as stipulated in ANNEX"A". Demurrage fees may be agreed upon by the parties.<br/> 1 The SECOND PARTY shall not affect any increase in trucking rate unless the same has been mutually agreed upon by both parties. Provided, however, that such agreement has been reduced to the writing prior to the effectivity of said increase. <br/>2 Payment shall be made by the FIRST PARTY to the SECOND PARTY within Fifteen (15) days upon receipt of the billing statement. The billing statement shall be submitted by the SECOND PARTY within three (3) working days after rendition of service. Otherwise, a 5% penalty of the total billing will be imposed in case of late billings. If the SECOND PARTY already violated the 3rd time, 10% penalty will be imposed. <br/> 3 The SECOND PARTY shall be held accountable in cases of loss and damage to the cargo of the FIRST PARTY under any and all circumstances while the same under the custody of the SECOND PARTY. In this regard, the SECOND PARTY is required to obtain an Insurance Coverage, with a limit of Php 5,000,000.00 (Five Million Pesos) per accident to cover FIRST PARTYs shipments with an insurance company acceptable to the <strong>FIRST PARTY attached herewith as <strong>ANNEX B

                Notwithstanding any other agreement, SECOND PARTY agrees to indemnify and hold harmless FIRST PARTY against all actions, suits and claims for damages or injury by whomsoever including but not limited to FIRST PARTYs employees or any other person or persons claiming any right, title or interest, that may be brought or made for any reason including but not limited to acts of God or non performance rules, regulations ordinances or laws or any of the covenant of this Agreement.
                Notwithstanding any applicable insurance that SECOND PARTY may have, SECOND PARTY shall indemnify, protect, defend and save free and harmless FIRST PARTY, its officers, directors, shareholders, agents and employees against and any and all liabilities, claims, suits, demands, damages, judgements, costs, fines, penalties, ineterest and expenses(inluding all professional fees and expenses thereof) which FIRST PARTY, its officers, directors, shareholders, agents, or employees may suffer or be made liable for, arising out of or in connection with the fault, negligence or carelessness of SECOND PARTY or anyone of its officers, directors, shareholders, agents or employees.
                
                Should SECOND PARTY be at the fault, FIRST PARTY shall likewise have the right to make either arrangements with the respect to the work or services to be performed including the right to immediately recover expenses and costs from the SECOND PARTYs bond.<br/>4. The FIRST PARTY reserves the right to offset the amount of any documented loss or damage sustained by the FIRST PARTY from any unpaid invoice of the SECOND PARTY. Likewise, chassis units allowed by Nippon to be used by subcontractor shall be maintained and accounted for by the trucker. any loss or damage shall be charged to the SECOND PARTY. Provided, that no such accountibility shall attach until both the FIRST PARTY and the SECOND PARTY shall have conducted and investigation and agreed on the existence of such intentional/negligent acts.<br/>5. During the course of this Agreement, either party may have access to one other s confidential information and materials. Both parties may agree to maintain any and all such informations in confidence and to take all measures to prevent unauthorized disclosure. A breach of this confidentiality shall be a ground for automatic termination of this Agreement and cause for the filing of a civil suit for damages.
                
                The provisions of this Section shall survive the expiration or termination of this Agreement for a period of two (2) years.<br/>6. The SECOND PARTY undertakes not to give any rebate, commission, cash gift or any gift of value to any FIRST PARTY s employees. Should such violation take place, this agreement shall be automatically voided. Not included in this prohibition, the Human Resource Department or Office of the President, on the occasion of a company celebration.<br/>7. This agreement shall take effect for a period of <u></u> commencing on <u></u> and ending on <u></u>. Renewal of the agreement will partly depend on the SECOND PARTY s services, which will be undertaken by the FIRST PARTY periodically.<br/>8. The FIRST PARTY reserves the right total terminate the contract by reason of the violation of any provision of this agreement or whenever it determines that the services of the SECOND PARTY no longer satisfactory meets its requirements, as well as when business condition so dedicated.
                
                The parties shall consult each other in good faith and shall exhaust all available remedies to settle any and all disputes or disagreements arising out of or relating the validity, interpretation, enforceablity, or performance under this Agreement. In case of failure to resolve the dispute and their joint decision shall be binding upon the reached between the two parties within fifteen (15) days from their initial meeting, the parties shall resort to arbitration as provided in Republic Act No.9285.<br/>9. This contract shall be construed, interpreted and governed by the laws of the Philippines. Venue of any court action instituted for the purpose of any enforcing any right or obligation or other  means of resolution shall be exclusively laid in the courts of the Philippines.<br/>',
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
