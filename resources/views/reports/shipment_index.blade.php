@extends('layouts.app')
@section('content')
<h2>&nbsp;Reports | Shipment</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">

				<h3>Shipment Report</h3>

				<div class = "form-horizontal">
				<div class = "form-group">
					<label class = "control-label col-md-3">Select Frequency: </label>
					<div class = "col-md-6 col-md-offset-1">
						<select class = "form-control" id = "frequency_select">
							<option value = "0"></option>
							<option value = "1">Daily</option>
							<option value = "2">Monthly</option>
							<option value = "3">Yearly</option>
							<option value = "4">Custom</option>
						</select>
					</div>
				</div>

				<div class = "collapse" id = "custom_collapse">
					<div class = "form-group">
						<div class = "col-md-2">
						</div>
						<div class = "col-md-8">
							<div class = "col-md-5">
								<label class = "control-label col-md-2">From: </label>
								<div class = "col-md-9 col-md-offset-1">
									<input type = "date"  class = "form-control" id = "from_date" style="width: 100%;" />
								</div>
							</div>
							<div class = "col-md-5">
								<label class = "control-label col-md-2">To: </label>
								<div class = "col-md-9 col-md-offset-1">
									<input type = "date"  class = "form-control" id = "to_date" sstyle="width: 100%;" />
								</div>
							</div>
							<div class = "col-md-2">
								<button class = "btn but custom_date">Go</button>
							</div>
						</div>
						<div class = "col-md-2">
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-primary print-report collapse">
					Print Reports <span class="fa fa-print" aria-hidden="true"></span>
				</button>

		</br>


	</br>

				<table class = "table table-responsive table-bordered table-hover collapse" style = "width: 150%" id = "shipment_table">
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
															echo "1x".$bc->containerVolume."</br>";
															echo $bc->containerNumber;
													}
											}
											foreach(  $brokerage_details as $nc)
											{
													if($nc->brok_head_id == $bh->order_no)
														{
															echo $nc->lcl_type."</br>";
															echo $nc->grossWeight." KGS. </br>";
															echo $nc->cubicMeters." CBM </br>";
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
										<table>

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
										<table>

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
																else
																{
																	$payment_format = number_format((float)2300, 2, '.', ',');
																	$total += 2300;
																	echo $payment_format;
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
																	break;
																}
																else
																{
																	$payment_format = number_format((float)800, 2, '.', ',');
																	$total += 800;
																	echo $payment_format;
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
@endsection
@push('styles')
<style>
	.class-shipment
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
	.table td.fit,
	.table th.fit {
			overflow: scroll; /* Scrollbar are always visible */
			overflow: auto;   /* Scrollbar is displayed as it's needed */
			white-space: nowrap;
			width: 1%;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse3').addClass('in');
	var data;
	var frequency;
	$(document).on('click', '.print-report', function(e){
		e.preventDefault();
		window.open("http://localhost:8000/reports/shipments/print/"+frequency);
	})

	$(document).on('change', '#frequency_select', function(e){
		e.preventDefault();
		var selected = $(this).val();

		switch (selected) {
			case "4" :
			$('#custom_collapse').addClass('in');
			$('#shipment_table').removeClass('in');
			$('.print-report').removeClass('in');
			break;
			case "1" :
			$('#shipment_table').removeClass('in');
			$('#custom_collapse').removeClass('in');
			$('#shipment_table').addClass('in');
			$('.print-report').addClass('in');
			frequency = "Daily Report: 10-14-2017";
			break;
			case "2" :
			$('#custom_collapse').removeClass('in');

			$('#shipment_table').removeClass('in');
			$('#custom_collapse').removeClass('in');
			$('#shipment_table').addClass('in');
			$('.print-report').addClass('in');
			frequency = "Monthly Report: October"
			break;
			case "3" :
			$('#custom_collapse').removeClass('in');

			$('#shipment_table').removeClass('in');
			$('#custom_collapse').removeClass('in');
			$('#shipment_table').addClass('in');
			$('.print-report').addClass('in');
			frequency = "Yearly Report: 2017"
			break;
		}
	});

	$(document).on('click', '.custom_date', function(e){
		$('#shipment_table').addClass('in');
		$('.print-report').addClass('in');
		if($('#from_date').val() != "" && $('#to_date').val() != ""){
			frequency = "Report: "+$('#from_date').val()+" to "+$('#to_date').val();
		}
	});
		//->brokerage_service_order_details.created_at','consignee_service_order_header.id',DB::raw('CONCAT(employees.firstName, employees.lastName) as Employee'), 'companyName', 'supplier', DB::raw('CONCAT(container_types.description,  containerNumber) as CONTRS'), 'docking', 'awb', 'deposit')
</script>
@endpush
