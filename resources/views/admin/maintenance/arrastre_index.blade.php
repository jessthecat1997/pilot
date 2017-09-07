@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Arrastre Fee</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#afModal" style = 'width: 100%;'>New Arrastre</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped" id = "af_table">
					<thead>
						<tr>
							<td>
								Location Port
							</td>
							<td>
								Container Size
							</td>
							<td>
								Arrastre Fee Amount
							</td>
							
							<td>
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<form role="form" method = "POST" class="commentForm">
		<div class="modal fade" id="afModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Arrastre</h4>
						</div>
						<div class="modal-body ">
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Location Port:</label>
								<select class = "form-control" id = "location_id">
									<option value = "0"></option>
									@forelse($locations as $location)
									<option value = "{{ $location->id }}">{{ $location->name }}</option>
									@empty
									@endforelse
								</select>
							</div>
						</form>
						<br />
						<div class = "collapse" id = "af_table_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one arrastre free per container.
							</div>
						</div>
						<div class = "collapse" id = "af_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the arrastre fees.
							</div>
						</div>
						<div class = "panel panel-default">
							<div  style="overflow-x: auto;">
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "arrastre_form" class = "commentForm">
										<table class="table responsive table-hover" width="100%" id= "af_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
											<thead>
												<tr>
													<td width="20%">
														<div class="form-group required">
															<label class = "control-label"><strong>Container Size</strong></label>
														</div>
													</td>

													<td width="20%">
														<div class="form-group required">
															<label class = "control-label"><strong>Arrastre Fee</strong></label>
														</div>
													</td>
													<td width="10%" style="text-align: center;">
														<strong>Action</strong>
													</td>
												</tr>
											</thead>
											<tr id = "af-row">
												<td>

													<div class = "form-group input-group" >
														
														<select class = "form-control af_container_size_valid" id = "container_size" name = "container_size" data-rule-required="true" >
															<option value = "0"></option>
															@forelse($sizes as $size)
															<option value = "{{ $location->id }}">{{ $size->name }}</option>
															@empty
															@endforelse
														</select><span class = "input-group-addon">-footer</span>
														
													</div>

												</td>
												<td>
													<div class = "form-group input-group " >
														<span class = "input-group-addon">Php</span>
														<input type = "text" class = "form-control amount_valid"
														value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/>
													</div>

												</td>
												<td style="text-align: center;">
													<button class = "btn btn-danger btn-md delete-af-row">x</button>
												</td>
											</tr>
										</table>
										<div class = "form-group" style = "margin-left:10px">
											<button    class = "btn btn-primary btn-md new-af-row pull-left">New Arrastre Fee</button>
											<br /><br/>
											
										</div>
									</div>
								</div>					
							</div>
							<small style = "color:red; text-align: left"><i>All fields are required.</i></small>
						</div>
						<div class="modal-footer">
							<button id = "btnSave" type = "submit" class="btn btn-success finalize-af">Save</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br/>
	</div>
</section>
<section class="content">
	<form role = "form" method = "POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<div class="modal fade" id="confirm-delete" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Deactivate record
					</div>
					<div class="modal-body">
						Confirm Deactivating
					</div>
					<div class="modal-footer">

						<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
</div>
@endsection
@push('styles')
<style>
	.class-af-fee
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
	.maintenance
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#brokeragecollapse').addClass('in');
	$('#collapse2').addClass('in');

	var container_size= [];
	var amount_value = [];
	var data, tblLength;
	var jsonContainerSize, jsonAmount;
	$(document).ready(function(){
		var af_row = "<tr>" + $('#af-row').html() + "</tr>";

		var aftable = $('#af_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			'scrollx': true,
			ajax: 'http://localhost:8000/admin/afData',
			columns: [
			{ data: 'location' },
			{ data: 'container_size',
			"render": function(data, type, row){
				return data.split(",").join("<br/>");}
			},
			{ data: 'amount',
			"render": function(data, type, row){
				return data.split(",").join("<br/>");}
			},
			
			{ data: 'action', orderable: false, searchable: false }
			],	"order": [[ 0, "desc" ]],
		});
		$("#commentForm").validate({
			rules:
			{
				dateEffective:
				{
					required: true,
				},

			},
			onkeyup: false,
			submitHandler: function (form) {
				return false;
			}
		});
		$(document).on('click', '.new', function(e){
			e.preventDefault();
			resetErrors();
			$('.modal-title').text('New Arrastre Fee Per Port');
			$('#afModal').modal('show');
			$("af_parent_table > tbody").html("");
			$('#af_parent_table > tbody').html(af_row);
			$('#amount').val("0.00");

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('.modal-title').text('Update Arrastre Fee Per Port');
			var af_id = $(this).val();
			data = aftable.row($(this).parents()).data();
			
			$('#afModal').modal('show');

			$.ajax({
				type: 'GET',
				url:  '{{ route("af_maintain_data") }}',
				data: {
					'_token' : $('input[name=_token').val(),
					'af_id' : $(this).val(),
				},
				success: function (data)
				{
					var rows = "";
					for(var i = 0; i < data.length; i++){
						rows += '<tr id = "af-row"><td><div class = "form-group input-group" ><span class = "input-group-addon">$</span><input type = "text" class = "form-control af_container_size_valid" value ="' + data[i].location + '" name = "minimum" id = "minimum"  data-rule-required="true" readonly="true"  style="text-align: right" /></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control amount_valid" value ="'+ data[i].amount+'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td><td style="text-align: center;"><button class = "btn btn-danger btn-md delete-af-row">x</button></td></tr>';
					}
					$('#af_parent_table > tbody').html("");
					$('#af_parent_table > tbody').append(rows);

				}

			})
		});
		$(document).on('click', '.deactivate', function(e){
			var af_id = $(this).val();
			data = aftable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});
		$(document).on('click', '.delete-af-row', function(e){
			e.preventDefault();
			$('#af_warning').removeClass('in');
			if($('#af_parent_table > tbody > tr').length == 1){
				$(this).closest('tr').remove();
				$('#af_table_warning').addClass('fade in');
			}
			else{
				$(this).closest('tr').remove();
			}
		})
		$(document).on('click', '.new-af-row', function(e){
			e.preventDefault();
			$('#af_table_warning').removeClass('fade in');
			if(validateIpfRows() === true){
				$('#af_parent_table').append(af_row);
				
			}
		})
		$(document).on('change', '.af_container_size_valid', function(e){
			$(".af_container_size_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
					$('#af_warning').removeClass('in');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})
		$(document).on('change', '.af_container_size_valid', function(e){
			$(".af_container_size_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
					$('#af_warning').removeClass('in');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})
		$(document).on('keypress', '.amount_valid', function(e){
			$(".amount_valid").each(function(){
				try{
					var amount = parseFloat($(this).val());
				}
				catch(err){
				}
				if(typeof(amount) === "string"){
				}
				else{
				}
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
					$('#af_warning').removeClass('in');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})
		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/arrastre_fee/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					aftable.ajax.reload();
					$('#confirm-delete').modal('hide');
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 2000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr["success"]("Record deactivated successfully")
				}
			})
		});
		$(document).on('click', '.finalize-af', function(e){
			e.preventDefault();
			if(finalvalidateIpfRows() === true){

				var title = $('.modal-title').text();
				if(title == "New Arrastre Fee Per Port")
				{

					jsonContainerSize = JSON.stringify(container_size);
					jsonAmount = JSON.stringify(amount_value);

					$.ajax({
						type: 'POST',
						url:  '/admin/arrastre_fee',
						data: {
							'_token' : $('input[name=_token]').val(),
							'location_id' : $('#location').val(),
							'container_size_id' : jsonContainerSize,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
						},
						success: function (data){

							aftable.ajax.reload();
							$('#afModal').modal('hide');
							$('.modal-title').text('New Arrastre Fee Per Port');
							
							$('#amount').val("0.00");
							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"rtl": false,
								"positionClass": "toast-bottom-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": 300,
								"hideDuration": 1000,
								"timeOut": 2000,
								"extendedTimeOut": 1000,
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							toastr["success"]("Record addded successfully")

						}
					})
				}else{



					
					jsonContainerSize = JSON.stringify(container_size_id);
					jsonAmount = JSON.stringify(amount_value);


					$.ajax({
						type: 'PUT',
						url:  '/admin/arrastre_fee/'+ data.id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'af_head_id': data.id,
							'dateEffective' : $('#dateEffective').val(),
							'container_sizes_id' : jsonContainerSize,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
						},
						success: function (data){

							aftable.ajax.reload();
							$('#afModal').modal('hide');
							$('.modal-title').text('New Arrastre Fee Per Port');
							
							$('#amount').val("0.00");

							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"rtl": false,
								"positionClass": "toast-bottom-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": 300,
								"hideDuration": 1000,
								"timeOut": 2000,
								"extendedTimeOut": 1000,
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							toastr["success"]("Record updated successfully")

						}
					})


				}
			}
		});
	});
function validateIpfRows()
{
	minimum_id = [];
	container_size_id = [];
	amount_value = [];
	minimum_id_descrp = [];
	
	amount_value_descrp = [];
	range_pairs = [];
	dateEffective = document.getElementsByName('dateEffective');
	minimum =  document.getElementsByName('minimum');
	maximum =   document.getElementsByName('maximum');
	amount =  document.getElementsByName('amount');
	error = "";

	var min, max;
	if(dateEffective === ""){
		dateEffective.style.borderColor = 'red';
		error += "Date Effective Required.";
	}
	for(var i = 0; i < minimum.length; i++){
		var temp;
		if(container_size[i].value === "")
		{
			container_size[i].style.borderColor = 'red';
			error += "Maximum Required.";
		}
		else
		{
			container_size[i].style.borderColor = 'green';
			
			container_size_id.push(container_size[i].value);
			$('#af_warning').removeClass('in');
		}
		if(amount[i].value === "")
		{
			amount[i].style.borderColor = 'red';
			error += "Amount Required.";
		}
		else
		{
			if(amount[i].value < 1){
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
			}
			else{
				amount[i].style.borderColor = 'green';
				amount_value.push(amount[i].value);
				$('#af_warning').removeClass('in');
			}
		}
		if(minimum[i].value === container_size[i].value){
			container_size[i].style.borderColor = 'red';
			error += "Same.";
		}

		min = parseFloat(minimum[i].value);
		max = parseFloat(container_size[i].value);
		if(min > max){

			console.log(min);
			console.log(max);
			container_size[i].style.borderColor = 'red';
			error += "Minimum is greater than maximum";
			$('#af_warning').addClass('in');

		}
		pair = {
			minimum: minimum[i].value,
			maximum : container_size[i].value
		};
		range_pairs.push(pair);
	}

	var i, j, n;
	found= false;
	n=range_pairs.length;
	for (i=0; i<n; i++) {
		for (j=i+1; j<n; j++)
		{
			if (range_pairs[i].minimum === range_pairs[j].maximum && range_pairs[i].maximum === range_pairs[j].maximum){
				found = true;

				container_size[i].style.borderColor = 'red';
				minimum[j].style.borderColor = 'red';
				container_size[j].style.borderColor = 'red';
			}
		}
	}
	if(found == true){
		error+= "Existing rate.";
	}
		//Final validation
		if(error.length == 0){

			return true;
		}
		else
		{
			return false;
		}
	}

	function finalvalidateIpfRows()
	{

		container_size_id = [];
		amount_value = [];
		range_pairs = [];
		container_size = document.getElementsByName('container_size');
		amount = document.getElementsByName('amount');

		error = "";



		for(var i = 0; i < container_size.length; i++){

			if(container_size[i].value === "")
			{
				container_size[i].style.borderColor = 'red';
				error += "Container size Required.";
				$('#af_warning').addClass('in');
			}
			else
			{
				container_size[i].style.borderColor = 'green';
				
				container_size_id.push(container_size[i].value);
				$('#af_warning').removeClass('in');
			}
			if(amount[i].value === ""||amount[i].value === "0.00"||amount[i].value === "0")
			{
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
				$('#af_warning').addClass('in');
			}
			else
			{
				if(amount[i].value < 0){
					amount[i].style.borderColor = 'red';
					error += "Amount Required.";
				}
				else{
					amount[i].style.borderColor = 'green';
					amount_value.push(amount[i].value);
					$('#af_warning').removeClass('in');
				}
			}


			pair = {
				amount: amount[i].value,
				container_size: container_size[i].value
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		found= false;
		n=range_pairs.length;
		for (i=0; i<n; i++) {
			for (j=i+1; j<n; j++)
			{
				if (range_pairs[i].container_size === range_pairs[j].container_size && range_pairs[i].amount === range_pairs[j].amount){
					found = true;

					container_size[i].style.borderColor = 'red';
					container_size[j].style.borderColor = 'red';
					amount[i].style.borderColor = 'red';
					amount[j].style.borderColor = 'red';


				}
			}
		}
		if(found == true){
			error+= "Existing rate.";
			$('#af_warning').addClass('in');
		}
		if(error.length == 0){
			tblLength = container_size.length;
			return true;
		}
		else
		{
			return false;
		}
	
}
function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush
