@extends('layouts.queries')

@section('content')
<div class = "col-md-12">
	<h3>Queries</h3>
	<hr>
	<div class = "col-md-12">
		<div class = "panel panel-default">
			<div class = "panel-heading">
				<div class = "form-horizontal">
					<div class = "form-group">
						<label class = "control-label col-md-3">Choose Query: </label>
						<div class = "col-md-6 col-md-offset-1">
							<select class = "form-control" id = "query_select">
								<option value = "0"></option>
								<option value = "1">Active Contracts</option>
								<option value = "2">Pending Deliveries</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class = "panel-body">
				<div class = "collapse" id = "contracts">
					<br />
					<table class = "table table-responsive" id = "contracts_table">
						<thead>
							<tr>
								<td>
									Contract No.
								</td>
								<td>
									Consignee
								</td>
								<td>
									Date Effective
								</td>
								<td>
									Termination Date
								</td>
								<td>
									Status
								</td>
								<td>
									Created At
								</td>
							</tr>
						</thead>
					</table>
				</div>
				<div class = "collapse" id = "delivery">
					<br />
					<table class = "table table-responsive" id = "delivery_table">
						<thead>
							<td style="width: 10%;">
								Del No.
							</td>
							<td style="width: 10%;">
								Consignee
							</td>
							<td style="width: 13%;">
								Plate Number
							</td>
							<td style="width: 15%;">
								Origin City
							</td>
							<td style="width: 10%;">
								Pickup Date
							</td>
							<td style="width: 15%;">
								Destination City
							</td>
							<td style="width: 15%;">
								Delivery Date
							</td>
						</thead>
					</table> 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change', '#query_select', function(e){
			e.preventDefault();
			console.log($('#query_select').val())
			switch($('#query_select').val()){
				case "0" :
				$('#contracts').removeClass('in');
				$('#delivery').removeClass('in');

				break;

				case "1" : 
				$('#contracts').addClass('in');
				$('#delivery').removeClass('in');

				var chtable;
				if ( ! $.fn.DataTable.isDataTable( '#contracts_table') ) {
					chtable = $('#contracts_table').DataTable({
						processing: false,
						deferRender: true,
						scrollX: true,
						serverSide: false,
						ajax: "{{ route('get_active_contract') }}",
						columns: [
						{ data: 'id' },
						{ data: 'name' },
						{ data: 'dateEffective' },
						{ data: 'dateExpiration' },
						{ data: 'status' },
						{ data: 'created_at' }
						]
					});
				}
				else{
					chtable.destroy();

					chtable = $('#contracts_table').DataTable({
						processing: false,
						deferRender: true,
						scrollX: true,
						serverSide: false,
						ajax: "{{ route('contract.data') }}",
						columns: [
						{ data: 'id' },
						{ data: 'companyName' },
						{ data: 'dateEffective' },
						{ data: 'dateExpiration' },
						{ data: 'status' },
						{ data: 'created_at' },
						{ data: 'action', orderable: false, searchable: false }
						]
					});
				}

				
				break;

				case "2" : 
				$('#delivery').addClass('in');
				$('#contracts').removeClass('in');
				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#delivery_table') ) {
					drtable = $('#delivery_table').DataTable({
						processing: false,
						deferRender: true,
						scrollX: true,
						serverSide: false,
						ajax: "{{ route('get_pending_deliveries') }}",
						columns: [
						{ data: 'id' },
						{ data: 'name' },
						{ data: 'plateNumber' },
						{ data: 'city_name' },
						{ data: 'pickupDateTime' },
						{ data: 'dcity_name' },
						{ data: 'deliveryDateTime' },
						
						]
					});
				}
				else{
					drtable.destroy();

					drtable = $('#delivery_table').DataTable({
						processing: false,
						deferRender: true,
						scrollX: true,
						serverSide: false,
						ajax: "{{ route('get_pending_deliveries') }}",
						columns: [
						{ data: 'id' },
						{ data: 'name' },
						{ data: 'plateNumber' },
						{ data: 'city_name' },
						{ data: 'pickupDateTime' },
						{ data: 'dcity_name' },
						{ data: 'deliveryDateTime' },
						]
					});
				}

				
				break;
			}
		})

		$(document).on('click', '.view', function(e){
			e.preventDefault();
		})
	})
</script>
@endpush