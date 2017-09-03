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
			@if($bills[0]->isRevenue == 1)
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
							{{ $bills[0]->companyName }}
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						Date:
					</td>
					@if($bills[0]->date_billed == NULL)
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							{{ Carbon\Carbon::parse($bills[0]->date_billed)->toFormattedDateString() }}
						</strong>
					</td>
					@else
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
								Not Set
						</strong>
					</td>
					@endif
				</tr>
				<tr>
					<td style="border:1px solid transparent;" width="20%">
						Address:
					</td>
					<td style="border:1px solid transparent;  text-align: left;" width="30%">
						<strong>
							{{ $bills[0]->address }}
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						Due Date:
					</td>
					@if($bills[0]->due_date == NULL)
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							{{ Carbon\Carbon::parse($bills[0]->due_date)->toFormattedDateString() }}
						</strong>
					</td>
					@else
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
								Not Set
						</strong>
					</td>
					@endif
				</tr>
				<tr>
					<td style="border:1px solid transparent;" width="20%">
						Business Style:
					</td>
					<td style="border:1px solid transparent;  text-align: left;" width="30%">
						<strong>
							{{ $bills[0]->businessStyle }}
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						TIN:
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							{{ $bills[0]->TIN }}
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
					@forelse($rev_bill as $pt)
					<tr>
						<td style="text-align: center;">
							{{ $pt->name }}
						</td>
						<td style="text-align: right;">
							Php {{ $pt->amount }}
						</td>
					</tr>
					@empty
					@endforelse
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td style="text-align: right">
							<strong>{{ $rev_vat[0]->rates }}%&nbsp;VAT</strong>
						</td>
						<td style="text-align: right;">
							Php&nbsp;{{ $rev_vat[0]->Total }}
						</td>
					</tr>
					<tr>
						<td style="text-align: right">
							<strong>TOTAL</strong>
						</td>
						<td style="text-align: right;">
							<h3>Php {{ $rev_total[0]->Total }}</h3>
						</td>
					</tr>
				</tbody>
			</table>
			@else
			<h3><center>Refundable Charges</center></h3>
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
							{{ $bills[0]->companyName }}
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						Date:
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							{{ Carbon\Carbon::parse($bills[0]->date_billed)->toFormattedDateString() }}
						</strong>
					</td>
				</tr>
				<tr>
					<td style="border:1px solid transparent;" width="20%">
						Address:
					</td>
					<td style="border:1px solid transparent;  text-align: left;" width="30%">
						<strong>
							{{ $bills[0]->address }}
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
							{{ $bills[0]->businessStyle }}
						</strong>
					</td>
					<td style="border:1px solid transparent;" width="20%">
						TIN:
					</td>
					<td style="border:1px solid transparent; text-align: left;" width="30%">
						<strong>
							{{ $bills[0]->TIN }}
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
					@forelse($exp_bill as $pt)
					<tr>
						<td style="text-align: center;">
							{{ $pt->name }}
						</td>
						<td style="text-align: right;">
							Php {{ $pt->amount }}
						</td>
					</tr>
					@empty
					@endforelse
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td style="text-align: right">
							<strong>{{ $exp_vat[0]->rates }}%&nbsp;VAT</strong>
						</td>
						<td style="text-align: right;">
							Php&nbsp;{{ $exp_vat[0]->Total }}
						</td>
					</tr>
					<tr>
						<td style="text-align: right">
							<strong>TOTAL</strong>
						</td>
						<td style="text-align: right;">
							<h3>Php {{ $exp_total[0]->Total }}</h3>
						</td>
					</tr>
				</tbody>
			</table>
			@endif
			<br />
			<br />
			<strong>JAY CASTILLO, LCB/MCA.</strong>
			<br>
			President
		</div>
	</div>
</body>
</html>
