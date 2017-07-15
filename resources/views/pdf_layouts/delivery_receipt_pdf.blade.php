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

		#dtr tr td {
			border: 1px transparent!important;
		}

		.value {
			border-left: 1px transparent!important;
		}


	</style>
</head>

<body>
	<div class="row">
		<div class = "container" style="text-align: center;">
			<br />
			<h2><small><strong style="text-align: center;">PILOT CARGO CHAINS SOLUTION INC.</strong></small></h2>
			
			<small><strong style="text-align: center;">3rd Floor, Unit 318 Velco Center Building, R.S. Oca &amp; A.C. Delgado St.</strong></small>
			<br />
			<small><strong style="text-align: center;">South Harbor, Port Area, Manila</strong></small>
			<br />
			<small><strong style="text-align: center;">Tel. Nos. 523-0201, 495-0832</strong></small>
		</div>
		<br />
		<div style = "width: 100%;">
			<div style="width: 50%;">
				<h3><strong>Delivery Receipt</strong></h3>
			</div>
		</div>
	</div>
	<div style="width: 100%;">
		<table style="width: 100%;" id = "info">
			<tr>
				<td >
					<span>Consignee:</span>
				</td>
				<td colspan="3" class="value">
					<span>{{ $delivery[0]->companyName }}</span>
				</td>
				<td>
					<span>Date</span>
				</td>
				<td>
					<span>{{ Carbon\Carbon::parse($delivery[0]->deliveryDate)->toFormattedDateString() }}</span>
				</td>
			</tr>
			<tr>
				<td>
					<span>Address:</span>
				</td>
				<td colspan="5">
					<span>{{ $delivery[0]->deliveryAddress }}</span>
				</td>
			</tr>
			<tr>
				<td style="width: 25%;">
					<small>DELIVERED BY:</small> Plate #
				</td>
				<td style="width: 15%;">
					<span>{{ $delivery[0]->plateNumber }}</span>
				</td>
				<td style="width: 10%;">
					<span>Driver:</span>
				</td>
				<td style="width: 20%;">
					<span>{{ $delivery[0]->driverName }}</span>
				</td>
				<td style="width: 10%;">
					<span>Helper:</span>
				</td>
				<td style="width: 20%;">
					<span>{{ $delivery[0]->helperName }}</span>
				</td>
			</tr>
		</table>
	</div>

	<br />
	
	@if($delivery[0]->withContainer == 1)
	<table style="width: 100%;">
		<thead>
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
		</thead>
		<tbody>
			<tr>
				<td>

				</td>
				<td>

				</td>
			</tr>
		</tbody>
	</table>
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
					<br />
					Supplier : {{ $delivery_detail->supplier }}
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
	<hr />
	<p><small><small>NOTE: Responsibility of PILOT CARGO CHAINS SOLUTIONS INC., ceases upon delivery to the consignee of all goods mentioned in this delivery.</small></small></p>
</body>
</html>