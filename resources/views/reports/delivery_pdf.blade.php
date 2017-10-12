<!DOCTYPE html>
<html>
<head>
	<title>
		
	</title>
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
	</style>
	<script type="text/javascript">
	</script>
</head>
<body>
	<table class = "table-responsive table" id = "customed_table">
		<thead>
			<tr>
				<td>
					Client
				</td>
				<td>
					Shipping Line
				</td>
				<td>
					Port of CFS Location
				</td>
				<td>
					Container
				</td>
				<td>
					Container Number
				</td>
				<td>
					Pickup Date
				</td>
				<td>
					Date of Delivery
				</td>
				<td>
					Remarks
				</td>
				<td>
					Delivery Year
				</td>	
			</tr>
		</thead>
		<tbody>
			@forelse($deliveries as $dr)
			<tr>
				<td>
					{{ $dr->name }}
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</body>

</html>