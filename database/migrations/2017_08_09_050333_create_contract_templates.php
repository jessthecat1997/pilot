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
                "'<p>1.  The <strong>FIRST PARTY</strong> may engage the trucking services of the SECOND PARTY on a per trip whenever exigencies require. This engagement is independent of any other agreement which may exists or has been previously executed between parties.
                </p>
                <br />
                <p>2.  Prior to signing this Hauling Agreement, the <strong>SECOND PARTY</strong>  shall submit to the <strong>FIRST PARTY</strong> the "."Standard Accreditation Requirements". "The <strong>SECOND PARTY</strong> commits that said requirements shall be accordingly updated or renewed when the need arises without need of demand from the <strong>FIRST PARTY</strong>.
                </p>
                <br />
                <p>3.  The <strong>SECOND PARTY</strong> commits that any and all trucks to be used in servicing the hauling needs of the <strong>FIRST PARTY</strong> shall be clean and in good running condition to ensure the safe and timely delivery / pick-up of cargoes.
                </p>
                <br />
                <p>4.  The <strong>SECOND PARTY</strong> shall assign one (1) driver and one (1) helper for each truck deployed to the <strong>FIRST PARTY</strong>. The <strong>SECOND PARTY</strong> shall ensure that the driver and helper thus deployed are neat in appearance. They must be in their proper uniform whenever servicing the hauling needs of the <strong>FIRST PARTY</strong>. Under no circumstances shall the <strong>SECOND PARTY</strong> deploy personnel wearing shorts, sando and / or slippers. <strong>SECOND PARTY</strong> is considered and independent contractor. Neither party is legal representative or agent of, or has the power to obligate the other for any purpose whatsoever. Both parties expressly acknowledge that the relationship intended by them is a business relationship based on, and defined by, the express provisions of the Agreement, and that no partnership, joint venture, affiliate, agency, or fiduciary relationship is intended or created by reason this Agreement.
                </p>
                <br />
                <p>5. Drivers and helpers shall be and remain <strong>SECOND PARTY's</strong> own employees and such employees will never be treated in anyway as <strong>FIRST PARTY's</strong> employees. In event that any of <strong>SECOND PARTY's</strong> employees assigned to <strong>FIRST PARTY's</strong> shall be awarded any labor-related claims against <strong>FIRST PARTY, SECOND PARTY</strong> shall shoulder and pay for the same.
                </p>
                <p>
                    In the fulfllment of its obligations under this Agreement <strong>SECOND PARTY</strong> shall select and hire its drivers and helpers assigned to <strong>FIRST PARTY</strong>. <strong>SECOND PARTY</strong> alone shall be responsible for the payment of their wages and other employment benefits and likewise for the safeguard of their health and safety in accordance with existing laws and regulation.
                </p>
                <p>
                    Likewise, <strong>SECOND PARTY</strong> shall be responsible for the discipline and/or dismissal of these personnel as well as be liable for damages or injuries caused by the third party.
                </p>
                <p>
                    It is understood that for the above reasons, these personnel shall be considered as sole employees of <strong>SECOND PARTY</strong>.
                </p>
                <p>6.  The <strong>SECOND PARTY</strong> warrants that any and all drivers and helpers manning the trucks deployed to the <strong>FIRST PARTY</strong> have undergone drug-testing and are cleared with NBI and PNP. The <strong>SECOND PARTY</strong> likewise commits to conduct an annual drug testing of the drivers and helpers thus mentioned.
                </p>
                <p>7.  The <strong>SECOND PARTY</strong> shall, at its own expense, adhere to the freight security guidelines and cargo/document handling procedures implemented by the <strong>FIRST PARTY</strong> or its customers. This includes, but is not limited to the provision of sturdy padlocks, chokes, early warning device, fire extinguisher, nylon ropes, flashlights, standard tool kit, etc.
                </p>
                <p>8.  As an added security measure, the <strong>SECOND PARTY</strong> shall provide any and all trucks deplyed to the <strong>FIRST PARTY</strong> with sufficient communication equipment such as cellular phones and GPS.
                </p>
                <p>9.  All repairs and maintenance expenses of the trucks shall be for the account of the <strong>SECOND PARTY</strong>. Toll fees, parking fees and other related expenses shall likewise be shouldered by the <strong>SECOND PARTY</strong>.
                </p>
                <p>10. For its services, the <strong>FIRST PARTY</strong> shall accordingly pay the sum equivalent to the agreed rates on a per trip, per truck basis to the <strong>SECOND PARTY</strong> as stipulated in <strong>ANNEX"."A"."</strong>. Demurrage fees may be agreed upon by the parties.
                </p>
                <p>11. The <strong>SECOND PARTY</strong> shall not effect any increase in trucking rate unless the same has been mutually agreed upon by both parties. Provided, however, that such agreement has been reduced to the writing prior to the effectivity of said increase.
                </p>
                <p>12. Payment shall be made by the <strong>FIRST PARTY</strong> to the <strong>SECOND PARTY</strong> within Fifteen (15) days upon receipt of the billing statement. The billing statement shall be submitted by the <strong>SECOND PARTY</strong> within three (3) working days after rendition of service. Otherwise, a 5% penalty of the total billing will be imposed in case of late billings. If the <strong>SECOND PARTY</strong> already violated the 3rd time, 10% penalty will be imposed.
                </p>
                <p>13. The <strong>SECOND PARTY</strong> shall be held accountable in cases of loss and damage to the cargo of the <strong>FIRST PARTY</strong> under any and all circumstances while the same under the custody of the <strong>SECOND PARTY</strong>. In this regard, the <strong>SECOND PARTY</strong> is required to obtain an Insurance Coverage, with a limit of Php 5,000,000.00 (Five Million Pesos) per accident to cover <strong>FIRST PARTY's</strong> shipments with an insurance company acceptable to the <strong>FIRST PARTY</strong> attached herewith as <strong>ANNEX'B'</strong>.
                </p>
                <p>Notwithstanding any other agreement, <strong>SECOND PARTY</strong> agrees to indemnify and hold harmless <strong>FIRST PARTY</strong> against all actions, suits and claims for damages or injury by whomsoever including but not limited to <strong>FIRST PARTY's</strong> employees or any other person or persons claiming any right, title or interest, that may be brought or made for any reason including but not limited to acts of God or non performance rules, regulations ordinances or laws or any of the covenant of this Agreement.
                </p>
                <p>Notwithstanding any applicable insurance that <strong>SECOND PARTY</strong> may have, <strong>SECOND PARTY</strong> shall indemnify, protect, defend and save free and harmless <strong>FIRST PARTY</strong>, its officers, directors, shareholders, agents and employees against and any and all liabilities, claims, suits, demands, damages, judgements, costs, fines, penalties, ineterest and expenses(inluding all professional fees and expenses thereof) which <strong>FIRST PARTY</strong>, its officers, directors, shareholders, agents, or employees may suffer or be made liable for, arising out of or in connection with the fault, negligence or carelessness of <strong>SECOND PARTY</strong> or anyone of its officers, directors, shareholders, agents or employees.
                </p>
                <p>Should <strong>SECOND PARTY</strong> be at the fault, <strong>FIRST PARTY</strong> shall likewise have the right to make either arrangements with the respect to the work or services to be performed including the right to immediately recover expenses and costs from the <strong>SECOND PARTY's</strong> bond.
                </p>
                <p>14. The <strong>FIRST PARTY</strong> reserves the right to offset the amount of any documented loss or damage sustained by the <strong>FIRST PARTY</strong> from any unpaid invoice of the <strong>SECOND PARTY</strong>. Likewise, chassis units allowed by Nippon to be used by subcontractor shall be <strong>maintained and accounted for by the trucker. any loss or damage shall be charged to the SECOND PARTY</strong>. Provided, that no such accountibility shall attach until both the <strong>FIRST PARTY</strong> and the <strong>SECOND PARTY</strong> shall have conducted and investigation and agreed on the existence of such intentional/negligent acts.
                </p>
                <p>15. During the course of this Agreement, either party may have access to one other's confidential information and materials. Both parties may agree to maintain any and all such informations in confidence and to take all measures to prevent unauthorized disclosure. A breach of this confidentiality shall be a ground for automatic termination of this Agreement and cause for the filing of a civil suit for damages.
                </p>
                <p>The provisions of this Section shall survive the expiration or termination of this Agreement for a period of two (2) years.
                </p>
                <p>16. The <strong>SECOND PARTY</strong> undertakes not to give any rebate, commission, cash gift or any gift of value to any <strong>FIRST PARTY's</strong> employees. Should such violation take place, this agreement shall be automatically voided. Not included in this prohibition, the Human Resource Department or Office of the President, on the occasion of a company celebration.
                </p>
                <p>17. This agreement shall take effect for a period of <strong><u></u></strong> commencing on <strong><u></u></strong> and ending on <strong><u></u></strong>. Renewal of the agreement will partly depend on the <strong>SECOND PARTY's</strong> services, which will be undertaken by the <strong>FIRST PARTY</strong> periodically.
                </p>
                <p>18. The <strong>FIRST PARTY</strong> reserves the right total terminate the contract by reason of the violation of any provision of this agreement or whenever it determines that the services of the <strong>SECOND PARTY</strong> no longer satisfactory meets its requirements, as well as when business condition so dedicated.
                </p>
                <p>The parties shall consult each other in good faith and shall exhaust all available remedies to settle any and all disputes or disagreements arising out of or relating the validity, interpretation, enforceablity, or performance under this Agreement. In case of failure to resolve the dispute and their joint decision shall be binding upon the reached between the two parties within fifteen (15) days from their initial meeting, the parties shall resort to arbitration as provided in Republic Act No.9285.
                </p>
                <p>19. This contract shall be construed, interpreted and governed by the laws of the Philippines. Venue of any court action instituted for the purpose of any enforcing any right or obligation or other  means of resolution shall be exclusively laid in the courts of the Philippines.
                </p>
                '",
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
