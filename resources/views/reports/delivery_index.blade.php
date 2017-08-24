@extends('layouts.reports')
@section('content')
<h2>&nbsp;Reports | Delivery</h2>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<h3>Delivery Report</h3>
				
				<div class = "form-horizontal">
					<div class = "form-group">
						<label class = "control-label col-md-3">Select Frequency: </label>
						<div class = "col-md-6 col-md-offset-1">
							<select class = "form-control" id = "frequency_select">
								<option value = "0"></option>
								<option value = "1">Daily</option>
								<option value = "2">Monthly</option>
								<option value = "3">Yearly</option>
								<option value = "4">Custom</option>
							</select>
						</div>
					</div>
					<div class = "collapse" id = "custom_collapse">
						<div class = "form-group">
							<div class = "col-md-2">
							</div>
							<div class = "col-md-8">
								<div class = "col-md-5">
									<label class = "control-label col-md-2">From: </label>
									<div class = "col-md-9 col-md-offset-1">
										<input type = "date"  class = "form-control" id = "from_date" style="width: 100%;" />
									</div>
								</div>
								<div class = "col-md-5">
									<label class = "control-label col-md-2">To: </label>
									<div class = "col-md-9 col-md-offset-1">
										<input type = "date"  class = "form-control" id = "to_date" sstyle="width: 100%;" />
									</div>
								</div>
								<div class = "col-md-2">
									<button class = "btn but custom_date">Go</button>
								</div>
							</div>
							<div class = "col-md-2">
							</div>
						</div>
					</div>
				</div>
				<div class = "collapse" id = "daily_collapse">
					<br />
					<table class = "table-responsive table" id = "daily_table">
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
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class = "collapse" id = "monthly_collapse">
					<br />
					<table class = "table-responsive table" id = "monthly_table">
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
									Delivery Month
								</td>	
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class = "collapse" id = "yearly_collapse">
					<br />
					<table class = "table-responsive table" id = "yearly_table">
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

						</tbody>
					</table>
				</div>
				<div class = "collapse" id = "customed_collapse">
					<br />
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

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
	.class-del_rep
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse3').addClass('in');
	var data;
	var shiptable;
	$(document).ready(function(){
		$(document).on('click', '.custom_date', function(e){
			$('#customed_collapse').addClass('in');
			if($('#from_date').val() != "" && $('#to_date').val() != ""){
				
				if ( ! $.fn.DataTable.isDataTable( '#customed_table') ) 
				{
					$.ajax({
						type: 'GET',
						url:  '{{ route("delivery.data")}}/4',
						data: {
							'_token' : $('input[name=_token').val(),
							'date_from' : $('#from_date').val(),
							'date_to' : $('#to_date').val(),
						},
						success: function (data)
						{

							var rows = "";
							var new_data = JSON.parse(data);
							console.log(new_data);
							for(var i = 0; i < new_data.length; i++){
								var name = (new_data[i].name == null ? "" : new_data[i].name);
								var shippingLine = (new_data[i].shippingLine == null ? "" : new_data[i].shippingLine);
								var portOfCfsLocation = (new_data[i].portOfCfsLocation == null ? "" : new_data[i].portOfCfsLocation);
								var containerVolume = (new_data[i].containerVolume == null ? "" : new_data[i].containerVolume);
								var containerNumber = (new_data[i].containerNumber == null ? "" : new_data[i].containerNumber);
								var pickupDateTime = (new_data[i].pickupDateTime == null ? "" : new_data[i].pickupDateTime);
								var deliveryDateTime = (new_data[i].deliveryDateTime == null ? "" : new_data[i].deliveryDateTime);
								var deliveryDateYear = (new_data[i].deliveryDateYear == null ? "" : new_data[i].deliveryDateYear);
								var remarks = (new_data[i].remarks == null ? "" : new_data[i].remarks);

								rows += "<tr><td>" + name +
								"</td><td>" + shippingLine +
								"</td><td>" + portOfCfsLocation +
								"</td><td>" + containerVolume +
								"</td><td>" + containerNumber +
								"</td><td>" + pickupDateTime +
								"</td><td>" + deliveryDateTime +
								"</td><td>" + remarks +
								"</td><td>" + deliveryDateYear +
								"</td></tr>";
							}
							$('#customed_table > tbody').html("");
							$('#customed_table > tbody').append(rows);

							$(document).ready(function() {
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
							} );
							
						}
					})

				}
				else
				{
					$("#customed_table").dataTable().fnDestroy();
					$("#customed_table > tbody").html("");
					$.ajax({
						type: 'GET',
						url:  '{{ route("delivery.data")}}/4',
						data: {
							'_token' : $('input[name=_token').val(),
							'date_from' : $('#from_date').val(),
							'date_to' : $('#to_date').val(),
						},
						success: function (data)
						{

							var rows = "";
							var new_data = JSON.parse(data);
							console.log(new_data);
							for(var i = 0; i < new_data.length; i++){
								var name = (new_data[i].name == null ? "" : new_data[i].name);
								var shippingLine = (new_data[i].shippingLine == null ? "" : new_data[i].shippingLine);
								var portOfCfsLocation = (new_data[i].portOfCfsLocation == null ? "" : new_data[i].portOfCfsLocation);
								var containerVolume = (new_data[i].containerVolume == null ? "" : new_data[i].containerVolume);
								var containerNumber = (new_data[i].containerNumber == null ? "" : new_data[i].containerNumber);
								var pickupDateTime = (new_data[i].pickupDateTime == null ? "" : new_data[i].pickupDateTime);
								var deliveryDateTime = (new_data[i].deliveryDateTime == null ? "" : new_data[i].deliveryDateTime);
								var deliveryDateYear = (new_data[i].deliveryDateYear == null ? "" : new_data[i].deliveryDateYear);
								var remarks = (new_data[i].remarks == null ? "" : new_data[i].remarks);

								rows += "<tr><td>" + name +
								"</td><td>" + shippingLine +
								"</td><td>" + portOfCfsLocation +
								"</td><td>" + containerVolume +
								"</td><td>" + containerNumber +
								"</td><td>" + pickupDateTime +
								"</td><td>" + deliveryDateTime +
								"</td><td>" + remarks +
								"</td><td>" + deliveryDateYear +
								"</td></tr>";
							}
							$('#customed_table > tbody').html("");
							$('#customed_table > tbody').append(rows);

							$(document).ready(function() {
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
											.append( '<td>'+rows.count()+'</td>' )
											.append( '<td/>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' );
										},
										dataSrc: 8
									},

								} );
								year.column(8).visible(false);
							} );
							
						}
					})
				}
			}
		});
		$(document).on('change', '#frequency_select', function(e){
			e.preventDefault();
			var selected = $(this).val();
			switch (selected) {
				case "1" : 
				$('#yearly_collapse').removeClass('in');
				$('#monthly_collapse').removeClass('in');
				$('#daily_collapse').addClass('in');
				$('#custom_collapse').removeClass('in');
				var shiptable;
				if ( ! $.fn.DataTable.isDataTable( '#daily_table') ) 
				{
					$.ajax({
						type: 'GET',
						url:  '{{ route("delivery.data")}}/1',
						data: {
							'_token' : $('input[name=_token').val()
						},
						success: function (data)
						{
							
							var rows = "";
							var new_data = JSON.parse(data);
							console.log(new_data);
							for(var i = 0; i < new_data.length; i++){
								var name = (new_data[i].name == null ? "" : new_data[i].name);
								var shippingLine = (new_data[i].shippingLine == null ? "" : new_data[i].shippingLine);
								var portOfCfsLocation = (new_data[i].portOfCfsLocation == null ? "" : new_data[i].portOfCfsLocation);
								var containerVolume = (new_data[i].containerVolume == null ? "" : new_data[i].containerVolume);
								var containerNumber = (new_data[i].containerNumber == null ? "" : new_data[i].containerNumber);
								var pickupDateTime = (new_data[i].pickupDateTime == null ? "" : new_data[i].pickupDateTime);
								var deliveryDateTime = (new_data[i].deliveryDateTime == null ? "" : new_data[i].deliveryDateTime);
								var remarks = (new_data[i].remarks == null ? "" : new_data[i].remarks);

								rows += "<tr><td>" + name +
								"</td><td>" + shippingLine +
								"</td><td>" + portOfCfsLocation +
								"</td><td>" + containerVolume +
								"</td><td>" + containerNumber +
								"</td><td>" + pickupDateTime +
								"</td><td>" + deliveryDateTime +
								"</td><td>" + remarks +
								"</td></tr>";
							}
							$('#daily_table > tbody').html("");
							$('#daily_table > tbody').append(rows);

							$(document).ready(function() {
								$('#daily_table').DataTable( {
									processing: false,
									deferRender: true,
									serverSide: false,
									"columnDefs": [
									{ "orderable": false, "targets": 7 }
									],
									order: [[6, 'asc']],
									rowGroup: {
										startRender: null,
										endRender: function ( rows, group ) {
											
											var ageAvg = rows
											.data()
											.pluck(3)
											.reduce( function (a, b) {
												return a + b*1;
											}, 0) / rows.count();

											return $('<tr/>')
											.append( '<td colspan="3">Deliveries for '+group+'</td>' )
											.append( '<td>'+rows.count()+'</td>' )
											.append( '<td/>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' );
										},
										dataSrc: 6
									},

								} );
							} );
							
						}
					})

				}
				else
				{

				}

				break;

				case "2" : 
				$('#yearly_collapse').removeClass('in');
				$('#monthly_collapse').addClass('in');
				$('#daily_collapse').removeClass('in');
				$('#custom_collapse').removeClass('in');
				var shiptable;
				if ( ! $.fn.DataTable.isDataTable( '#monthly_table') ) 
				{
					$.ajax({
						type: 'GET',
						url:  '{{ route("delivery.data")}}/2',
						data: {
							'_token' : $('input[name=_token').val()
						},
						success: function (data)
						{
							var rows = "";
							var new_data = JSON.parse(data);
							console.log(new_data);
							for(var i = 0; i < new_data.length; i++){
								var name = (new_data[i].name == null ? "" : new_data[i].name);
								var shippingLine = (new_data[i].shippingLine == null ? "" : new_data[i].shippingLine);
								var portOfCfsLocation = (new_data[i].portOfCfsLocation == null ? "" : new_data[i].portOfCfsLocation);
								var containerVolume = (new_data[i].containerVolume == null ? "" : new_data[i].containerVolume);
								var containerNumber = (new_data[i].containerNumber == null ? "" : new_data[i].containerNumber);
								var pickupDateTime = (new_data[i].pickupDateTime == null ? "" : new_data[i].pickupDateTime);
								var deliveryDateTime = (new_data[i].deliveryDateTime == null ? "" : new_data[i].deliveryDateTime);
								var deliveryDateMonth = (new_data[i].deliveryDateMonth == null ? "" : new_data[i].deliveryDateMonth);
								var remarks = (new_data[i].remarks == null ? "" : new_data[i].remarks);

								rows += "<tr><td>" + name +
								"</td><td>" + shippingLine +
								"</td><td>" + portOfCfsLocation +
								"</td><td>" + containerVolume +
								"</td><td>" + containerNumber +
								"</td><td>" + pickupDateTime +
								"</td><td>" + deliveryDateTime +
								"</td><td>" + remarks +
								"</td><td>" + deliveryDateMonth +
								"</td></tr>";
							}
							$('#monthly_table > tbody').html("");
							$('#monthly_table > tbody').append(rows);

							$(document).ready(function() {
								var month = $('#monthly_table').DataTable( {
									processing: false,
									deferRender: true,
									serverSide: false,
									"columnDefs": [
									{ "orderable": false, "targets": 7 }
									],
									order: [[8, 'asc']],
									rowGroup: {
										startRender: null,
										endRender: function ( rows, group ) {
											
											var ageAvg = rows
											.data()
											.pluck(3)
											.reduce( function (a, b) {
												return a + b*1;
											}, 0) / rows.count();

											return $('<tr/>')
											.append( '<td colspan="3">Deliveries for '+group+'</td>' )
											.append( '<td>'+rows.count()+'</td>' )
											.append( '<td/>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' );
										},
										dataSrc: 8
									},

								} );
								month.column(8).visible(false);
							} );

							
						}
					})

				}
				else
				{

				}

				break;

				case "3" : 
				$('#yearly_collapse').addClass('in');
				$('#monthly_collapse').removeClass('in');
				$('#daily_collapse').removeClass('in');
				$('#custom_collapse').removeClass('in');
				var shiptable;
				if ( ! $.fn.DataTable.isDataTable( '#yearly_table') ) 
				{
					$.ajax({
						type: 'GET',
						url:  '{{ route("delivery.data")}}/3',
						data: {
							'_token' : $('input[name=_token').val()
						},
						success: function (data)
						{
							var rows = "";
							var new_data = JSON.parse(data);
							console.log(new_data);
							for(var i = 0; i < new_data.length; i++){
								var name = (new_data[i].name == null ? "" : new_data[i].name);
								var shippingLine = (new_data[i].shippingLine == null ? "" : new_data[i].shippingLine);
								var portOfCfsLocation = (new_data[i].portOfCfsLocation == null ? "" : new_data[i].portOfCfsLocation);
								var containerVolume = (new_data[i].containerVolume == null ? "" : new_data[i].containerVolume);
								var containerNumber = (new_data[i].containerNumber == null ? "" : new_data[i].containerNumber);
								var pickupDateTime = (new_data[i].pickupDateTime == null ? "" : new_data[i].pickupDateTime);
								var deliveryDateTime = (new_data[i].deliveryDateTime == null ? "" : new_data[i].deliveryDateTime);
								var deliveryDateYear = (new_data[i].deliveryDateYear == null ? "" : new_data[i].deliveryDateYear);
								var remarks = (new_data[i].remarks == null ? "" : new_data[i].remarks);

								rows += "<tr><td>" + name +
								"</td><td>" + shippingLine +
								"</td><td>" + portOfCfsLocation +
								"</td><td>" + containerVolume +
								"</td><td>" + containerNumber +
								"</td><td>" + pickupDateTime +
								"</td><td>" + deliveryDateTime +
								"</td><td>" + remarks +
								"</td><td>" + deliveryDateYear +
								"</td></tr>";
							}
							$('#yearly_table > tbody').html("");
							$('#yearly_table > tbody').append(rows);

							$(document).ready(function() {
								var year = $('#yearly_table').DataTable( {
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

											return $('<tr/>')
											.append( '<td colspan="3">Deliveries for Year '+group+'</td>' )
											.append( '<td>'+rows.count()+'</td>' )
											.append( '<td/>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' )
											.append( '<td>'+'</td>' );
										},
										dataSrc: 8
									},

								} );
								year.column(8).visible(false);
							} );
							
						}
					})

				}
				else
				{

				}

				break;

				case "4" : 
				$('#yearly_collapse').removeClass('in');
				$('#monthly_collapse').removeClass('in');
				$('#daily_collapse').removeClass('in');
				$('#custom_collapse').addClass('in');
			}
		})
})
</script>
@endpush