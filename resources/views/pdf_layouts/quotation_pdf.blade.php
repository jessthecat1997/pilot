<!DOCTYPE html>
<html>
<head>
	<title>View Quotation</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
		}
		table tr, td, th {
			border: 1px solid black;

		}
		th, td {
			padding: 10px;
		}

		.page-break
		{
			page-break-after: always;
		}
	</style>

</head>
<body>
	<div class="row">
		<div class = "container">
			<div style="float: left;">
				<img src="{{ public_path() }}\images\pilotlogo.png"/>
			</div>
			<div style="margin-left: 200px;">
				<br />
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

			<div>
				<br />
				<br />
				<strong>{{ Carbon\Carbon::parse($quotation[0]->created_at)->toFormattedDateString() }}</strong>
				<br />
				<br />
				Mr./Mrs. <span><strong>{{ $quotation[0]->name }}</strong></span>
				<br />
				<br />
				We are pleased to submit our proposal for your import and Export requirements to and from the following destinations;
				
			</div>

			<div>
				@if(count($quotation_details) > 0)
				<h3>Rates</h3>

				<table style="border: 1px solid black; width: 100%;">
					<thead>
						<tr>
							<th width="20%" style="text-align: center;">
								<strong>From</span></strong>
							</th>
							<th width="20%" style="text-align: center;">
								<strong>To</strong>
							</th>
							<th width="20%" style="text-align: center;">
								<strong>Sizes</strong>
							</th>
							<th width="20%" style="text-align: center;">
								<strong>Rate</strong>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse($quotation_details as $quotation_detail)
						<tr>
							<td> 
								{{ $quotation_detail->_from }} 
							</td> 
							<td> 
								{{ $quotation_detail->_to }} 
							</td>
							<td> 
								{{ $quotation_detail->sizes }} 
							</td> 
							<td> 
								Php {{ $quotation_detail->amount }} 
							</td> 
						</tr>
						@empty
						<tr>
							<td>
								<h4 style="text-align: center;">No records available.</h4>
							</td>
						</tr>
						@endforelse
					</tbody>
				</table>

				@endif
			</div>

			<br />
			<h3>Terms and Conditions</h3>
			@if($quotation[0]->specificDetails == null)
			<h5 style="text-align: center;">No specified details</h5>
			@else
			<p>{!! $quotation[0]->specificDetails !!}</p>
			@endif
			
			<p>Looking forward to do business with you and your company.</p>
			
			<p>Thank you very much.</p>
			<br />
			<table style="width: 100%;">
				<tr>
					<td style="width: 50%; border: 1px solid transparent;">
						<strong>JAY CASTILLO, LCB/MCA.</strong>
						<br>
						President
					</td>
					<td style="width: 50%; border: 1px solid transparent;">
						<strong>{{ strtoupper($quotation[0]->name) }}, {{ strtoupper($quotation[0]->companyName) }}</strong>
						<br>
						Conforme
					</td>
				</tr>	
			</table>
		</div>
	</div>
</body>
</html>