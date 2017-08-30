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
			<div>
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
			<table style="width: 100%;">
				<tr>
					<td style="border-style: none;" colspan="2"><strong>OFFICIAL RECEIPT</strong></td>
					<td style="border-style: none; text-align: right;">No:</td>
					<td style="border-style: none;">{{ $payment->id }}</td>
				</tr>
				<tr>
					<td style="border-style: none; text-align: left;" colspan="4"><span style="margin-right: 30px;">Date: {{ Carbon\Carbon::parse($payment->created_at)->toFormattedDateString() }}</span></td>
				</tr>
				<tr>
					<td style="border-style: none; width: 50%;" colspan="2"><label><strong>Received from: &nbsp;&nbsp;</strong></label>{{ $bill[0]->firstName . " " . $bill[0]->lastName }}</td>
					
					<td style="border-style: none; width: 20%; text-align: right:"><label><strong>with TIN</strong></label>
					<td style="border-style: none; width: 30%;">{{ $bill[0]->TIN }}</td>
				</tr>
				<tr>
					<td style="border-style: none; width: 20%;" colspan="4"><label><strong>and address at</strong></label> &nbsp;&nbsp;{{ $bill[0]->address }}</td>
				</tr>
				<tr>
					<td style="border-style: none; width: 70%;" colspan="4"><label><strong>engaged in the business style of</strong></label>&nbsp;&nbsp;{{ $bill[0]->businessStyle }}</td>
				</tr>
				<tr>
					<td style="border-style: none; width: 20%;" colspan="4"><label><strong>the sum of</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;<label><strong>Php {{ $payment->amount }}</strong></label></td>
				</tr>
			</table>
			<br/>
			<table>
				<tr>
					<td colspan="2">In settlement of the following:</td>
				</tr>
				<tr>
					<td style="text-align: center;">Billing Invoice No.</td>
					<td style="text-align: center;">Amount</td>
				</tr>
				<tr>
					<td style="text-align: center;">{{ $bill[0]->bill_id }}</td>
					<td style="text-align: center;">{{ $bill[0]->Total }}</td>
				</tr>
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