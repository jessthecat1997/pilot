<!DOCTYPE html>
<html>
<head>
	<title>View Delivery Receipt</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
		}
		table tr, td, th {
			border: 1px solid black;

		}
		th{
			text-align: center;
		}
		th, td {
			padding: 10px;
		}

		.page-break
		{
			page-break-after: always;
		}
		.underlined_text
		{
			border-bottom: 1px solid black;
		}

		span {
			word-wrap: break-word;
		}

		#dtr tr td 	{
			border: 1px transparent!important;
		}

		#header tr td 	{
			border: 1px transparent!important;
		}


		.remove_left


	</style>
</head>

<body>
	<div class="row">
		<div class = "container" style="text-align: center;">
			<h2><small><strong style="text-align: center;">PILOT CARGO CHAIN SOLUTION INC.</strong></small></h2>
			
			<small><strong style="text-align: center;">3rd Floor, Unit 318 Velco Center Building, R.S. Oca &amp; A.C. Delgado St.</strong></small>
			<br />
			<small><strong style="text-align: center;">South Harbor, Port Area, Manila</strong></small>
			<br />
			<small><strong style="text-align: center;">Tel. Nos. 523-0201, 495-0832</strong></small>
		</div>
		<table style="width: 100%;" id = "header" >
			<tr>
				<td style="width: 80%;">
					<h3>Delivery Receipt</h3>
				</td>
				<td style="width: 5%;">
					<span>No.</span>
				</td>
				<td style="width: 15%; text-align: center; padding-top: 5px;"">

					<span style="padding-top: 10px;">{{ $delivery[0]->id }}</span>
					<hr style="margin-top: 5px;" />
				</td>
			</tr>
		</table>
	</div>
	<div style="width: 100%;">
		<table style="width: 100%;" id = "info">
			<tr>
				<td  style="border-right: 1px solid transparent;">
					<span><strong>Consignee:</strong></span>
				</td>
				<td colspan="3" style="border-left: 1px solid transparent; margin-left: -80px;">
					<span>{{ $delivery[0]->companyName }}</span>
				</td>
				<td style="border-right: 1px solid transparent;">
					<span><strong>Date: </strong></span>
				</td>
				<td style="border-left: 1px solid transparent;">
					<span>{{ Carbon\Carbon::parse($delivery[0]->deliveryDateTime)->toFormattedDateString() }}</span>
				</td>
			</tr>
			<tr>
				<td style="width: 10%; border-right: 1px solid transparent;">
					<span><strong>Address: </strong></span>
				</td>
				<td colspan="5" style="border-left: 1px solid transparent;">
					<span>{{ $delivery[0]->deliveryAddress }}</span>
				</td>
			</tr>
			<tr>
				<td style="width: 25%; border-right: 1px solid transparent;">
					<strong><small>DELIVERED:</small> Plate #</strong>
				</td>
				<td style="width: 15%; border-left: 1px solid transparent;">
					<span>{{ $delivery[0]->plateNumber }}</span>
				</td>
				<td style="width: 10%; border-right: 1px solid transparent;">
					<span><strong>Driver:</strong></span>
				</td>
				<td style="width: 20%; border-left: 1px solid transparent;">
					<span>{{ $delivery[0]->driverName }}</span>
				</td>
				<td style="width: 10%; border-right: 1px solid transparent;">
					<span><strong>Helper: </strong></span>
				</td>
				<td style="width: 20%; border-left: 1px solid transparent;">
					<span>{{ $delivery[0]->helperName }}</span>
				</td>
			</tr>
		</table>
	</div>

	<br />
	
	@if($delivery[0]->withContainer == 1)
	<section>
		<table style="width: 100%;">
				<tr>
					<th style="width: 10%;">
						Quantity
						<br />
						Marks &amp;
						<br />
						Numbers
					</th>
					<th style="width: 20%;">
						Gross Weight
						<br />
						And
						<br />
						Measurement
					</th>
					<th style="width: 70%;">
						Description of Goods / Shipments
					</th>
				</tr>
			<tbody>
				@forelse($container_with_detail as $container)
				@php
				$num = 1;
				@endphp

				<tr>
					<td style="text-align: center;">
						{{ $container['container']->containerVolume }}
					</td>
					<td colspan="2">
						Container Number: {{ $container['container']->containerNumber }}
					</td>
				</tr>

				@forelse($container['details'] as $detail)
				<tr>
					<td style="text-align: right;">
						{{ $num++ }}
					</td>
					<td style="text-align: right;">
						{{ $detail->grossWeight }}
					</td>
					<td>
						{{ $detail->descriptionOfGoods }}
						@if( $detail->supplier != "")
						<br />
						Supplier: {{ $detail->supplier }}
						@endif
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="3">
						<h5 style="text-align: center;">No records found.</h5>
					</td>
				</tr>
				@endforelse
				@empty

				@endforelse
				<tr>
					<td colspan="3">
						<table style="width: 100%;" id = "dtr">
							<tr>
								<td class="remove_table_tr" style="width: 5%;">
									Date:
								</td>
								<td class = "remove_table_tr" style="width: 25%;">
									<hr  style="margin-top: 18px;" />
								</td>
								<td class="remove_table_tr" style="width: 15%;">
									Time in:
								</td>
								<td class = "remove_table_tr" style="width: 20%;">
									<hr  style="margin-top: 18px;" />
								</td>
								<td class="remove_table_tr" style="width: 5%;">
									Signature: 
								</td>
								<td class = "remove_table_tr" style="width: 30%;">
									<hr  style="margin-top: 18px;" />
								</td>
							</tr>
							<tr>
								<td class="remove_table_tr" style="width: 5%;">
									Date:
								</td>
								<td class = "remove_table_tr" style="width: 25%;">
									<hr  style="margin-top: 18px;" />
								</td>
								<td class="remove_table_tr" style="width: 15%;">
									Time out:
								</td>
								<td class = "remove_table_tr" style="width: 20%;">
									<hr  style="margin-top: 18px;" />
								</td>
								<td class="remove_table_tr" style="width: 5%;">
									Signature: 
								</td>
								<td class = "remove_table_tr" style="width: 30%;">
									<hr  style="margin-top: 18px;" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</section>
	@else
	@php
	$num = 1;
	@endphp
	<table style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 5%;">
					No.
				</th>
				<th style="width: 25%;">
					Gross Weight (kg)
				</th>
				<th style="width: 70%;">
					Description of Goods / Shipments
				</th>
			</tr>
		</thead>
		<tbody>
			@forelse($delivery_details as $delivery_detail)
			<tr>
				<td>
					{{ $num++ }}
				</td>
				<td style="text-align: right;">
					{{ $delivery_detail->grossWeight}}
				</td>
				<td>
					{{ $delivery_detail->descriptionOfGoods }}
					@if($delivery_detail->supplier != "")
					<br />
					Supplier : {{ $delivery_detail->supplier }}
					@endif
				</td>
			</tr>

			@empty

			@endforelse
			<tr>
				<td colspan="3">
					<table style="width: 100%;" id = "dtr">
						<tr>
							<td class="remove_table_tr" style="width: 5%;">
								Date:
							</td>
							<td class = "remove_table_tr" style="width: 25%;">
								<hr  style="margin-top: 18px;" />
							</td>
							<td class="remove_table_tr" style="width: 15%;">
								Time in:
							</td>
							<td class = "remove_table_tr" style="width: 20%;">
								<hr  style="margin-top: 18px;" />
							</td>
							<td class="remove_table_tr" style="width: 5%;">
								Signature: 
							</td>
							<td class = "remove_table_tr" style="width: 30%;">
								<hr  style="margin-top: 18px;" />
							</td>
						</tr>
						<tr>
							<td class="remove_table_tr" style="width: 5%;">
								Date:
							</td>
							<td class = "remove_table_tr" style="width: 25%;">
								<hr  style="margin-top: 18px;" />
							</td>
							<td class="remove_table_tr" style="width: 15%;">
								Time out:
							</td>
							<td class = "remove_table_tr" style="width: 20%;">
								<hr  style="margin-top: 18px;" />
							</td>
							<td class="remove_table_tr" style="width: 5%;">
								Signature: 
							</td>
							<td class = "remove_table_tr" style="width: 30%;">
								<hr  style="margin-top: 18px;" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	@endif
	<div>
		<h3>SHIPPER'S / CONSIGNEE'S ACKNOWLEDGEMENT</h3>
		<p><small>THIS WILL CERTIFY THAT ABOVE DESCRIBED GOODS WAS DELIVERED IN GOOD ORDER &amp; CONDITION.</small></p>
	</div>
	<br />
	<div style="display: block; clear: right;">
		<div style="width: 100%;">
			<div style="width: 50%;display: inline-block; float: left; ">
				<div style="width: 80%; text-align: center;">
					<hr />
					Authorized Representative
					<br />
					Full Name &amp; Signature
				</div>
			</div>
		</div>
		<div style="width: 100%; display: inline-block;">
			<div style="width: 50%; display: inline-block; float: right; ">
				<div style="width: 80%; text-align: center;">
					<hr />
					Date &amp; Time
				</div>
			</div>
		</div>
	</div>
	<br />
	<br />
	<br />
	<br />
	<br />
	<small><small>NOTE: Responsibility of PILOT CARGO CHAIN SOLUTIONS INC., ceases upon delivery to the consignee of all goods mentioned in this delivery.</small></small>
</body>
</html>