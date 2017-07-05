@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "panel-default panel">
				<div class = "panel-heading">
					<h2>Contracts</h2>
				</div>
				<div class = "panel-body">
					<h3 id = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>
					<hr />
					<div class = "col-md-12">
						<div class = "panel-default">
							<div id="con_collapse" class="collapse in">
								<br />
								<table class="display responsive no-wrap" width="100%" id = "cs_table">
									<thead>
										<tr>
											<td>
												Full Name
											</td>
											<td>
												Company Name
											</td>
											<td>
												Customer
											</td>
											<td>
												Email
											</td>
											<td>
												Contact Number
											</td>
											<td>
												Created At
											</td>
											<td>
												Actions
											</td>
										</tr>
									</thead>
								</table>
							</div>
							<div id ="detail_collapse" class = "collapse">
								<form class="form-horizontal" role="form">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="control-label col-sm-3" for="pwd">Full Name:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "lastName" id="lastName" placeholder="Enter Last Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="companyName">Company Name:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "companyName" id="companyName" placeholder="Enter Company Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="email">Email</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "email" id="email" placeholder="Enter Email Address">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="contactNumber">Contact Number:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
										</div>
									</div>
								</form>	
							</div>
							
						</div>
					</div>

					<br />
					<br />
					<h3><small>2</small>&nbsp;&nbsp;Contract Information</h3>
					<hr />
					<form class = "form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-3" for="consigneeName">Consignee:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name = "consigneeName" id="consigneeName" placeholder="Consignee Name">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="dateEffective">Date Effective:</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="dateExpiration">Date Expiration:</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" name = "dateExpiration" id="dateExpiration" placeholder="Enter Expiration Date">
							</div>
						</div>
					</form>

					<br />
					<br />

					<h3><small>3</small>&nbsp;&nbsp;Contract Rates</h3>
					<hr />
					<div class = "col-md-12">
						<div class = "panel-default">
							<table class="table responsive table-hover" width="100%" id= "contract_parent_table" style = "overflow-x: scroll;">
								<thead>
									<tr>
										<td>
											Area From
										</td>
										<td>
											Area To
										</td>
										
										<td>
											Amount
										</td>
										<td>
											Action
										</td>
									</tr>
								</thead>
								<tr id = "contract-row">
									<td>
										<select name = "areas_id_from" id = "areas_id_from" class = "form-control ">
											<option>

											</option>
											@forelse($areas as $area)
											<option value = "{{ $area->id }}">
												{{ $area->description }}
											</option>
											@empty

											@endforelse
										</select>
									</td>
									<td>
										<select name = "areas_id_to" id = "areas_id_to" class = "form-control">
											<option>

											</option>
											@forelse($areas as $area)
											<option value = "{{ $area->id }}">
												{{ $area->description }}
											</option>
											@empty

											@endforelse
										</select>
									</td>
									
									<td>
										<input type = "text" name = "amount" class = "form-control" style="text-align: right">

									</td>
									<td>
										<button class = "btn btn-success btn-md new-contract-row">New Rate</button>
										<button class = "btn btn-danger btn-md delete-contract-row">Remove</button>
										<button class = "btn btn-primary btn-md view-contract-row">View</button>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<br />
					<br />
					<h3><small>3</small>&nbsp;&nbsp;Contract Details</h3>
					<textarea class = "form-control" style = "max-width: 100%; min-width: 100%;" placeholder="Specific notes about the contract..." name = "specificDetails" id = "specificDetails"></textarea>

					<br />
					<br />
					<h3><small>4</small>&nbsp;&nbsp;Finalize</h3>
					<button class = "btn btn-md btn-success finalize-contract" style = "width: 100%;">Create Contract</button>	
				</div>
			</div>
		</div>
	</div> 
</div>
@endsection
@push('styles')
<style>
.contracts
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
$('#collapse1').addClass('in');
	var from_id = [];
	var to_id = [];

	var amount_value = [];
	var consigneeID;
	var from_id_descrp = [];
	var to_id_descrp = [];
	var amount_value_descrp = [];

	$(document).ready(function(){
		var contract_row = "<tr>" + $('#contract-row').html() + "</tr>";
		var cstable = $('#cs_table').DataTable({			
			responsive: true,
			"scrollX": true,
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/admin/csData',
			columns: [

			{ data: 'firstName' },
			{ data: 'companyName' },
			{ data: 'consigneeType' },
			{ data: 'email' },
			{ data: 'contactNumber' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});
		$.fn.dataTable.ext.errMode = 'throw';

		$(document).on('click', '.changeConsignee', function(e){
			$('#con_collapse').addClass('in');
			$('#detail_collapse').removeClass('in');
			$('#firstName').val("");
			$('#companyName').val("");
			$('#email').val("");
			$('#contactNumber').val("");

			$("#con-info-header").html('<h3 class = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>');
		})

		$(document).on('click', '.view-contract-row', function(e){
			data = $('#contract_parent_table:even').html();
			console.log(data);
		})

		$(document).on('click', '.selectConsignee' ,function(e){
			consigneeID = $(this).val();
			$('#con_collapse').removeClass('in');
			$('#detail_collapse').addClass('in');
			var cs_id = $(this).val();
			data = cstable.row($(this).parents()).data();
			$('#lastName').val(data.firstName);
			$('#consigneeName').val(data.firstName);
			$('#companyName').val(data.companyName);
			$('#email').val(data.email);
			$('#contactNumber').val(data.contactNumber);

			$("#con-info-header").html('<h3 class = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information<button class="btn btn-info pull-right changeConsignee">Change Consignee</button></h3>');
		})

		$(document).on('click', '.new-contract-row', function(e){
			if(validateContractRows() === true){
				$('#contract_parent_table:last-child').append(contract_row);
			}

		})

		$(document).on('click', '.finalize-contract', function(e){
			if(validateContractRows() === true){
				$.ajax({
					method: 'POST',
					url: '{{ route("create_contract") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'consigneeName' : $('#consigneeName').val(),
						'dateEffective' : $('#dateEffective').val(),
						'dateExpiration' : $('#dateExpiration').val(),
						'areas_from' : from_id,
						'areas_to' : to_id,
						'from_id_descrp' : from_id_descrp,
						'to_id_descrp' : to_id_descrp,
						'amount' : amount_value,
						'consigneeID' : consigneeID,
						'specificDetails' : $('#specificDetails').val(),
					},

					success: function (data){
						window.location.replace("{{route('contracts.index')}}"+ "/" + data + "/view");
					}

				})
			}
		})

	})

	function validateContractRows()
	{
		from_id = [];
		to_id = [];
		cv_id = [];
		amount_value = [];

		from_id_descrp = [];
		to_id_descrp = [];
		cv_id_descrp = [];
		amount_value_descrp = [];

		from = document.getElementsByName('areas_id_from');
		to = document.getElementsByName('areas_id_to');
		amount = document.getElementsByName('amount');
		error = "";

		if(consigneeID === null)
		{
			error+= "No selected consignee";
		}

		for(var i = 0; i < from.length; i++){

			if(from[i].value === "")
			{
				from[i].style.color = 'red';	
				error += "From Required.";

			}

			else
			{
				from_id_descrp.push(from[i].options[from[i].selectedIndex].text);
				from_id.push(from[i].value);
			}
			if(to[i].value === "")
			{
				to[i].style.color = 'red';
				error += "To Required.";
			}

			else
			{
				to_id_descrp.push(to[i].options[to[i].selectedIndex].text);
				to_id.push(to[i].value);
			}

			if(amount[i].value === "")
			{
				amount[i].style.color = 'red';
				error += "Amount Required.";
			}

			else
			{
				amount_value.push(amount[i].value);
			}
		}

		if(error.length == 0){
			return true;
		}

		else
		{
			return false;
		}

	}

</script>
@endpush