<!DOCTYPE html>
<html>
<head>
	<title></title>
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
			<h3>Rates</h3>

			<table style="border: 1px solid black; width: 100%;">
				<thead>
					<tr>
						<th width="30%" style="text-align: center;">
							<strong>From</span></strong>
						</th>
						<th width="30%" style="text-align: center;">
							<strong>To</strong>
						</th>
						<th width="30%" style="text-align: center;">
							<strong>Rate</strong>
						</th>
					</tr>
				</thead>
				<tbody>
					@forelse($contract_details as $contract_detail)
					<tr>
						<td>
							{{ $contract_detail->from }}
						</td>
						<td>
							{{ $contract_detail->to }}
						</td>
						<td style="text-align: right;">
							{{ $contract_detail->amount }}
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
			
			<br />
			<h3>Terms and Conditions:</h3>
			<p>{{ $contract->specificDetails }}</p>
			<br />
			<br />
			<p>Looking forward to do business with you and your company.</p>
			<br />
			<br />
			<p>Thank you very much.</p>

			<br />
			<br />
			<strong>JAY CASTILLO, LCB/MCA.</strong>
			<br>
			President
		</div>
	</div>
</body>
</html>