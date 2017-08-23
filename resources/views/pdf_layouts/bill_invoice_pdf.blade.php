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
			<div style="text-align: center;">
				<small style="text-align: center;">Freight Forwarding, Customs Clearance (Air &amp; Sea), Project &amp; Heavy Equipment</small>
			</div>
			<hr />
			<h3><center>Billing Invoice</center></h3>
			<table style="width: 100%; border: 1px solid black">
				<tr>
					<td style="border:1px solid transparent; text-align: left;" width="20%">
						<h4>Invoice No.:</h4>
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<h3>0{{ $number }}</h3>
					</td>
				</tr>
				<tr>
					<td style="border:1px solid transparent;" width="20%">
						BILLED TO:
					</td>
					<td style="border:1px solid transparent;  text-align: left;" width="30%">
						<strong>
							@forelse($bills as $bill)
							{{ $bill->companyName }}
							@empty
							@endforelse
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						Date:
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							@forelse($bills as $bill)
							{{ Carbon\Carbon::parse($bill->created_at)->toFormattedDateString() }}
							@empty
							@endforelse
						</strong>
					</td>
				</tr>
				<tr>
					<td style="border:1px solid transparent;" width="20%">
						Address:
					</td>
					<td style="border:1px solid transparent;  text-align: left;" width="30%">
						<strong>
							@forelse($bills as $bill)
							{{ $bill->address }}
							@empty
							@endforelse
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						Terms:
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							
						</strong>
					</td>
				</tr>
				<tr>
					<td style="border:1px solid transparent;" width="20%">
						Business Style:
					</td>
					<td style="border:1px solid transparent;  text-align: left;" width="30%">
						<strong>
							@forelse($bills as $bill)
							{{ $bill->businessStyle }}
							@empty
							@endforelse
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						TIN:
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							@forelse($bills as $bill)
							{{ $bill->TIN }}
							@empty
							@endforelse
						</strong>
					</td>
				</tr>
			</table>
			<br/>
			<table style="border: 1px solid black; width: 100%;">
				<thead>
					<tr>
						<th width="70%" style="text-align: center;">
							<strong>P A R T I C U L A R S</span></strong>
						</th>
						<th width="30%" style="text-align: center;">
							<strong>Amount</strong>
						</th>					
					</tr>
				</thead>
				<tbody>
					@forelse($parts as $pt)
					<tr>
						<td style="text-align: center;">
							{{ $pt->name }}
						</td>
						<td style="text-align: right;">
							Php {{ $pt->Total }}
						</td>
					</tr>
					@empty
					@endforelse
					<tr>
						<td style="text-align: right">
							<strong>TOTAL</strong>
						</td>
						<td style="text-align: right;">
							Php {{ $total[0]->Total }}
						</td>
					</tr>
				</tbody>
			</table>
			<br />
			<br />
			<strong>JAY CASTILLO, LCB/MCA.</strong>
			<br>
			President
		</div>
	</div>
</body>
</html>
