<!DOCTYPE html>
<html>
<head>
	<title>

	</title>
	<style type="text/css">	</style>
	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/js/jqueryDatatable/dataTables.bootstrap.min.css">
	<script src="/js/app.js"></script>
	<script type="text/javascript" charset="utf8" src="/js/jqueryDatatable/jquery.dataTables.min.js"></script>

</head>
<body>
	<div style="float: left;">
		<img src="{{ public_path() }}\images\pilotlogo.png" style="width: 100px; height: 100px;" />
	</div>
	<div style="margin-left: 200px;">
		<br />
		@forelse($utility as $util)
		<small><strong style="text-align: center;">{{ $util->company_name }}</strong></small>
		<br />
		<small><strong style="text-align: center;">{{ $util->company_address }}</strong></small>
		@empty
		@endforelse
		<br />
		<hr />
	</div>
	<h2>Delivery Report</h2>
	<table class = "table-responsive table table-bordered table-striped" id = "customed_table">
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
					Status
				</td>
			</tr>
		</thead>
		<tbody>
			@forelse($deliveries as $dr)
			<tr>
				<td>
					{{ $dr->name }}
				</td>
				<td>
					{{ $dr->shippingLine }}
				</td>
				<td>
					{{ $dr->portOfCfsLocation }}
				</td>
				<td>
					{{ $dr->containerVolume }}
				</td>
				<td>
					{{ $dr->containerNumber }}
				</td>
				<td>
					{{ $dr->pickupDateTime}}
				</td>
				<td>
					{{ $dr->deliveryDateTime }}
				</td>
				<td>
					{{ $dr->remarks }}
				</td>
				<td>
					@php
					if($dr->status == 'P'){ echo('Pending'); }
					else if ( $dr->status == 'F' ) { echo('Finished'); }
					else if ( $dr->status == 'C' ) { echo('Cancelled'); }
					@endphp
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="9" style="text-align: center;">
					No records found.
				</td>
			</tr>
			@endforelse
		</tbody>
	</table>
</body>
<script type="text/javascript">
	var year = $('#customed_table').DataTable( {
		processing: false,
		deferRender: true,
		serverSide: false,
		"columnDefs": [
		{ "orderable": false, "targets": 7 }
		],
		order: [[5, 'asc']],
		rowGroup: {
			startRender: null,
			endRender: function ( rows, group ) {

				var ageAvg = rows
				.data()
				.pluck(3)
				.reduce( function (a, b) {
					return a + b*1;
				}, 0) / rows.count();

				var date_from = $('#from_date').val();
				var date_to = $('#to_date').val();

				return $('<tr/>')
				.append( '<td colspan="3">Deliveries Between '+ date_from + ' and ' + date_to +'</td>' )
				.append( '<td>'+ rows.count() + '</td>' )
				.append( '<td/>' )
				.append( '<td>'+'</td>' )
				.append( '<td>'+'</td>' )
				.append( '<td>'+'</td>' );
			},
			dataSrc: 8
		},

	} );
	year.column(8).visible(false);
</script>

</html>
