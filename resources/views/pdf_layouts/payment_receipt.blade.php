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
				<img src="{{ public_path() }}\images\pilotlogo.png" style="width: 100px; height: 100px;" />
			</div>
			<div style="margin-left: 200px;">
				<br />
				@forelse($utility as $util)
				<small><strong style="text-align: center;">{{ $util->company_name }}</strong></small>
				<br />
				<small><strong style="text-align: center;">{{ $util->company_address }}</strong></small>
				<br />
				<small><strong style="text-align: center;">Tel. Nos. 999-9999</strong></small>
				<br />
				<small><strong style="text-align: center;">Fax: 999-999</strong></small>
				<br />
				<small><strong style="text-align: center;">Email add: sample@yahoo.com</</strong></small>
				@empty
				@endforelse
			</div>
			<br />
			<div style="text-align: center;">
				<small style="text-align: center;">Freight Forwarding, Customs Clearance (Air &amp; Sea), Project &amp; Heavy Equipment</small>
			</div>
			<hr />
			<strong><center>@if($bill[0]->billtype == 1)OFFICIAL RECEIPT @else ACKNOWLEDGEMENT RECEIPT @endif</strong></center>
			<table style="width: 100%;">
				<tr>
					<td style="border-style: none;">OR No: {{ $payment->id }}</td>
				</tr>
				<tr>
					<td style="border-style: none; text-align: left;"><span style="margin-right: 30px;">Date: {{ Carbon\Carbon::parse($payment->created_at)->toFormattedDateString() }}</span></td>
				</tr>
				<tr>
					<td style="border-style: none; width: 100%;"><label><strong>Received from: &nbsp;&nbsp;</strong></label>{{ $bill[0]->firstName . " " . $bill[0]->lastName }}</td>
				</tr>
				<tr>
					<td style="border-style: none; width: 20%;" colspan="4"><label><strong>Address: </strong></label> &nbsp;&nbsp;{{ $bill[0]->address }}</td>
				</tr>
				<tr>
					<td style="border-style: none; width: 20%;" colspan="4"><label><strong>the sum of</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Php {{ $payment->amount }}</strong></label></td>
				</tr>
			</table>
			<br/>
			<table width="100%">
			<tr>
					<td colspan="3">In settlement of the following:</td>
				</tr>
			<tr>
				<td>
					Invoice Number
				</td>
				<td>
					Amount
				</td>
				<td>
					Balance
				</td>
			</tr>
				<tr>
					<td style="text-align: center;">{{ $bill[0]->bill_id }}</td>
					<td style="text-align: center;">{{ $bill[0]->Total }}</td>
					<td style="text-align: center;">{{ $bill[0]->balance }}</td>
				</tr>
			</table>
			<br />
			<br />
			<strong>JAY CASTILLO, LCB/MCA.</strong>President
			<br/>
			Printed by: {{ Auth::user()->name }}
		</div>
	</div>
</body>
</html>