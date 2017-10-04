@extends('layouts.queries')

@section('content')
<div class = "col-md-12">
	<h2>&nbsp;Queries</h2>
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
								<option value = "2">Expired Contracts</option>
								<option value = "3">Contract Drafts</option>
								<option value = "4">Pending Deliveries</option>
								<option value = "5">Cancelled Deliveries</option>
								<option value = "6">List of Today's Deliveries</option>
								<option value = "7">List of Unreturned Containers</option>
								<option value = "8">List of Near Due Date Bills</option>
								<option value = "9">List of Overdue Bills</option>
								<option value = "10">Expiring Vehicle Registrations</option>
								<option value = "11">Finished Trucking Orders</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class = "panel-body">
				<div class = "collapse" id = "contracts_active">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "active_contracts_table" style="width: 100%;">
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
				<div class = "collapse" id = "contracts_expired">
					<br />
				<table class = "table table-responsive table-bordered table-striped" id = "expired_contracts_table" style="width: 100%;">
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
				<div class = "collapse" id = "contracts_draft">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "draft_contracts_table" style="width: 100%;">
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
				<div class = "collapse" id = "pending_delivery">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "pending_delivery_table" style="width: 100%;">
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
				<div class = "collapse" id = "cancelled_delivery">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "cancellled_delivery_table" style="width: 100%;">
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
				<div class = "collapse" id = "today_delivery">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "today_delivery_table" style="width: 100%;">
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
				<div class = "collapse" id = "unreturned_containers">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "unreturned_containers_table" style="width: 100%;">
						<thead>
							<td style="width: 15%;">
								Container Number
							</td>
							<td style="width: 20%;">
								Container Volumes
							</td>
							<td style="width: 20%;">
								Return To
							</td>
							<td style="width: 20%;">
								Return Date
							</td>
							<td style="width: 20%;">
								Return Address
							</td>

						</thead>
					</table> 
				</div>
				<div class = "collapse" id = "near_bills">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "near_bills_table" style="width: 100%;">
						<thead>
							<td style="width: 13s%;">
								ID
							</td>
							<td style="width: 20%;">
								Consignee
							</td>
							<td style="width: 20%;">
								Due Date
							</td>
							<td style="width: 20%;">
								Status
							</td>
							<td style="width: 20%;">
								Actions
							</td>
						</thead>
					</table> 
				</div>
				<div class = "collapse" id = "overdue_bills">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "overdue_bills_table" style="width: 100%;">
						<thead>
							<td style="width: 13s%;">
								ID
							</td>
							<td style="width: 20%;">
								Consignee
							</td>
							<td style="width: 20%;">
								Due Date
							</td>
							<td style="width: 20%;">
								Status
							</td>
							<td style="width: 20%;">
								Actions
							</td>
						</thead>
					</table> 
				</div>

				<div class = "collapse" id = "exp_registrations">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "exp_registrations_table" style="width: 100%;">
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

				<div class = "collapse" id = "finished_truckings">
					<br />
					<table class = "table table-responsive table-bordered table-striped" id = "finished_truckings_table" style="width: 100%;">
						<thead>
							<td style="width: 20%;">
								ID
							</td>
							<td style="width: 20%;">
								Consignee
							</td>
							<td style="width: 20%;">
								Employee
							</td>
							<td style="width: 20%;">
								Action
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
		$(document).on('click', '.view-finish', function(e){
			e.preventDefault();
			window.location.href = "{{ route('trucking.index') }}/" + $(this).val() + "/view";
		})
		$(document).on('change', '#query_select', function(e){
			e.preventDefault();
			console.log($('#query_select').val())
			switch($('#query_select').val()){
				case "0" :
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');
				break;

				case "1" : 
				$('#contracts_active').addClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');

				var chtable;
				if ( ! $.fn.DataTable.isDataTable( '#active_contracts_table') ) {
					chtable = $('#active_contracts_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_active_contract') }}/A",
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
				else
				{

				}

				break;

				case "2" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').addClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');

				var chtable;
				if ( ! $.fn.DataTable.isDataTable( '#expired_contracts_table') ) {
					chtable = $('#expired_contracts_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_active_contract') }}/E",
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
				else
				{

				}

				break;

				case "3" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').addClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');

				var chtable;
				if ( ! $.fn.DataTable.isDataTable( '#draft_contracts_table') ) {
					chtable = $('#draft_contracts_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_active_contract') }}/D",
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
				else
				{

				}

				break;

				case "4" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').addClass('in');
				$('#finished_truckings').removeClass('in');

				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#pending_delivery_table') ) {
					drtable = $('#pending_delivery_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_pending_deliveries') }}/P",
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

				}

				
				break;

				case "5" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').addClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');

				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#cancellled_delivery_table') ) {
					drtable = $('#cancellled_delivery_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_pending_deliveries') }}/C",
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

				}

				
				break;

				case "6" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').addClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');

				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#today_delivery_table') ) {
					drtable = $('#today_delivery_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_pending_deliveries') }}/T",
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

				}

				
				break;

				case "7" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').addClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');

				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#unreturned_containers_table') ) {
					drtable = $('#unreturned_containers_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_unreturned_containers') }}",
						columns: [
						{ data: 'containerNumber' },
						{ data: 'containerVolume'},
						{ data: 'containerReturnTo' },
						{ data: 'containerReturnAddress' },
						{ data: 'containerReturnDate' },
						
						
						]
					});
				}
				else{

				}

				
				break;

				case "8" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').addClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');
				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#near_bills_table') ) {
					drtable = $('#near_bills_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_query_bills') }}/N",
						columns: [
						{ data: 'id' },
						{ data: 'name' },
						{ data: 'due_date'},
						{ data: 'status'},	
						{ data: 'action' },
						
						]
					});
				}
				else{

				}

				
				break;

				case "9" : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').addClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').removeClass('in');
				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#overdue_bills_table') ) {
					drtable = $('#overdue_bills_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_query_bills') }}/O",
						columns: [
						{ data: 'id' },
						{ data: 'name' },
						{ data: 'due_date'},
						{ data: 'status'},	
						{ data: 'action' },
						
						]
					});
				}
				else{

				}

				
				break;


				case '11' : 
				$('#contracts_active').removeClass('in');
				$('#contracts_expired').removeClass('in');
				$('#contracts_draft').removeClass('in');
				$('#exp_registrations').removeClass('in');
				$('#overdue_bills').removeClass('in');
				$('#near_bills').removeClass('in');
				$('#unreturned_containers').removeClass('in');
				$('#today_delivery').removeClass('in');
				$('#cancelled_delivery').removeClass('in');
				$('#pending_delivery').removeClass('in');
				$('#finished_truckings').addClass('in');

				var drtable;
				if ( ! $.fn.DataTable.isDataTable( '#finished_truckings_table') ) {
					drtable = $('#finished_truckings_table').DataTable({
						processing: false,
						deferRender: true,
						serverSide: false,
						ajax: "{{ route('get_finished_trucking_orders') }}",
						columns: [
						{ data: 'id' },
						{ data: 'consignee' },
						{ data: 'employee' },
						{ data: 'action' },
						
						
						]
					});
				}
				else{

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