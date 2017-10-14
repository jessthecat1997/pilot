<!DOCTYPE html>
<html>
<head>

  <style type="text/css">
  table.gridtable {
  	font-family: verdana,arial,sans-serif;
  	font-size:11px;
  	color:#333333;
  	border-width: 1px;
  	border-color: #666666;
  	border-collapse: collapse;
  }
  table.gridtable th {
  	border-width: 1px;
  	padding: 8px;
  	border-style: solid;
  	border-color: #666666;
  	background-color: #dedede;
  }
  table.gridtable td {
  	border-width: 1px;
  	padding: 8px;
  	border-style: solid;
  	border-color: #666666;
  	background-color: #ffffff;
  }

  table.insidegridtable {
    font-family: verdana,arial,sans-serif;
    font-size:11px;
    color:#333333;
    border: none;
  }
  table.insidegridtable th {
    padding: 5px;
    background-color: #dedede;
    border: none;
  }
  table.insidegridtable td {
    padding: 3px;
    background-color: #ffffff;
    border: none;
  }
  </style>




</head>

<body>
  <div style="float: left;">
    <img src="{{ public_path() }}\images\pilotlogo.png"/>
  </div>
  <div style="margin-left: 200px;">
    <br />
    <small><strong style="text-align: center;">PILOT CARGO CHAIN SOLUTION INC.</strong></small>
    <br />
    <small><strong style="text-align: center;">Suite 318 Velco Center Building Port Area Manila</strong></small>
    <br />
    <small><strong style="text-align: center;">Tel. Nos. 523-0201, 495-0832</strong></small>
    <br />
    <small><strong style="text-align: center;">Fax: 523-0201</strong></small>
    <br />
    <small><strong style="text-align: center;">Email add: jay@pilotcargochain.com / jca_pilot@yahoo.com.ph</</strong></small>
  </div>
  <br />
  <br />

  <div style="text-align: center;">
    <small style="text-align: center;">Freight Forwarding, Customs Clearance (Air &amp; Sea), Project &amp; Heavy Equipment</small>
  </div>
  <hr />
<br/>

    <big><strong style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shipment Report (2017)</</strong></big>

<br /><br /><br />
    <div class = "container-fluid">
    	<div class="row">
    		<div class = "panel-default panel">
    			<div class = "panel-body">

    				<div class = "form-horizontal">

    			</br>
    		</br>


    	</br>
          {{$frequency}}<label> </label>
        <br/><br/>
    				<table class = "table table-responsive table-bordered table-hover gridtable" style = "width: 100%" id = "shipment_table">
    							<thead>
    								<tr>
    									<th>
    										Date
    									</th>
    									<th>
    										File No.
    									</th>
    									<th>
    										Processor
    									</th>
    									<th>
    										Consignee
    									</th>
    									<th>
    										Supplier
    									</th>
    									<th>
    										No. Of Containers
    									</th>
    									<th>
    										Port
    									</th>
    									<th>
    										Shipping Line
    									</th>

    									<th>
    										Request
    									</th>
    									<th>
    										Amount
    									</th>

    								</tr>
    							</thead>
    							<tbody>
    								@forelse($brokerage_header as $bh)
    								<tr>
    									<td>
    										@php
    										$date = $bh->dateCreated;
    											echo $date =  date("F j, Y") @endphp
    									</td>
    									<td>
    										{{$bh->order_no}}
    									</td>
    									<td>
    										@php
    										$fullName = $bh->firstName ." ". $bh->lastName;
    											echo $fullName @endphp
    									</td>
    									<td>
    										{{$bh->companyName}}
    									</td>
    									<td>
    										{{$bh->shipper}}
    									</td>
    									<td>
    										@php
    											foreach($brokerage_containers as $bc)
    											{
    													if($bc->brok_so_id == $bh->order_no)
    													{
    															echo "1x".$bc->containerVolume."<br/>";
    															echo $bc->containerNumber;
    													}
    											}
    											foreach(  $brokerage_details as $nc)
    											{
    													if($nc->brok_head_id == $bh->order_no)
    														{
    															echo $nc->lcl_type."<br/>";
    															echo $nc->grossWeight." KGS. <br/>";
    															echo $nc->cubicMeters." CBM <br/>";
    														}
    											}
    										@endphp
    									</td>
    									<td>
    										{{$bh->name}}
    									</td>
    									<td>
    										@php
    											foreach($brokerage_containers as $bc)
    											{
    													if($bc->brok_so_id == $bh->order_no)
    													{
    															echo $bc->shippingLine;

    													}
    											}
    											foreach(  $brokerage_details as $nc)
    											{
    													if($nc->brok_head_id == $bh->order_no)
    														{
    															echo "Loose Cargo";

    														}
    											}
    										@endphp
    									</td>

    									<td>
    										<table class = "insidegridtable">

    					 						<tr>
    												<td>
    							 						Processing
    												</td>
    					 						</tr>

    											<tr>
    												<td>
    							 						 THC
    												 </td>
    					 						</tr>

    											<tr>
    												<td>
    							 						 Deposit
    												 </td>
    					 						</tr>

    											<tr>
    						 						<td>
    							 						 Arrastre
    						 						</td>
    					 						</tr>

    											<tr>
    						 						<td>
    							 						 Demmurage
    						 						</td>
    					 						</tr>

    											<tr>
    						 						<td>
    							 						 Other
    						 						</td>
    					 						</tr>

    											<tr>
    						 						<td>
    							 						 Total
    						 						</td>
    					 						</tr>

    				 			  		</table>
    									</td>

    									<td>
    										<table class = "insidegridtable">

    											<tr>
    												<td>
    													@php
    														$total = 0.00;
    														foreach($payments as $payment)
    														{
    															if($payment->so_head_id)
    															{
    																if($payment->charge_name == 'Processing')
    																{
    																	$payment_format = number_format((float)$payment->charge_payment, 2, '.', ',');
    																	echo $payment_format;
    																	$total += $payment->charge_payment;
    																}
    															}
    														}
    													@endphp
    												</td>
    											</tr>

    											<tr>
    												<td>
    													@php
    														foreach($payments as $payment)
    														{
    															if($payment->so_head_id)
    															{
    																if($payment->charge_name == 'Terminal Handling Charges')
    																{
    																	$payment_format = number_format((float)$payment->charge_payment, 2, '.', ',');
    																	echo $payment_format;
    																	$total += $payment->charge_payment;
    																	break;

    																}
    															}
    														}
    													@endphp
    												</td>
    											</tr>

    											<tr>
    												<td>
    												 --
    												</td>
    											</tr>

    											<tr>
    												<td>
    													@php
     													 foreach($arrastres as $arrastre)
     													 {
     														 if($arrastre->so_head_id == $bh->order_no)
     														 {

    															 $arrastre_format = number_format((float) $arrastre->arrastre_sum, 2, '.', ',');
    																echo $arrastre_format;
    																$total +=  $arrastre->arrastre_sum;

     														 }
     													 }
     												 @endphp
    												</td>
    											</tr>

    											<tr>
    												<td>
    													@php
    														foreach($payments as $payment)
    														{
    															if($payment->so_head_id )
    															{
    																if($payment->charge_name == 'Demurrage')
    																{

    																	$payment_format = number_format((float)$payment->charge_payment, 2, '.', ',');
    																	echo $payment_format;
    																	$total += $payment->charge_payment;
    																}
    															}
    														}
    													@endphp
    												</td>
    											</tr>

    											<tr>
    												<td>
    													--
    												</td>
    											</tr>

    											<tr>
    												<td>
    													@php
    																$total = number_format((float)$total, 2, '.', ',');
    															echo $total;
    													@endphp
    												</td>
    											</tr>

    										</table>
    									</td>
    								</tr>

    								@empty
    								<tr>
    									No Records Found
    								</tr>
    								@endforelse

    							</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</body>

</html>
