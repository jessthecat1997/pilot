@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Less Cargo Load Arrastre Fee</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#wfModal" style = 'width: 100%;'>New Arrastre</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped" id = "wf_table">
					<thead>
						<tr>
							<td>
								Location Pier
							</td>
							<td>
								Less Cargo Load Type
							</td>
							<td>
								Basis
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
		<div class="modal fade" id="wfModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Arrastre Fee Per Pier</h4>
						</div>
						<div class="modal-body ">
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Location Pier:</label>
								<select class = "form-control" id = "locations_id" placeholder ="Choose a pier location">
									@forelse($locations as $location)
									<option value = "{{ $location->id }}">{{ $location->name }}</option>
									@empty
									@endforelse
								</select>
							</div>
						</form>
						<br />
						<div class = "collapse" id = "wf_table_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one Arrastre free per container.
							</div>
						</div>
						<div class = "collapse" id = "wf_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the Arrastre fees.
							</div>
						</div>
						<div class = "panel panel-default">
							<div  ">
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "Arrastre_form" class = "commentForm">
										<table class="table responsive table-hover"  id= "wf_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
											<thead>
												<tr>
													<td >
														<div class="form-group required">
															<label class = "control-label"><strong>Less Cargo Load Type</strong></label>
														</div>
													</td>
													<td >
														<div class="form-group required">
															<label class = "control-label"><strong>Basis</strong></label>
														</div>
													</td>
													<td width = "40%" >
														<div class="form-group required">
															<label class = "control-label"><strong>Arrastre Fee</strong></label>
														</div>
													</td>
													<td >
														<div >
															<label class = "control-label"><strong>Action</strong></label>
														</div>
													</td>
													
													
												</tr>
											</thead>
											<tr id = "wf-row">
												<td width = "20%">

													<div class = "form-group " >
														
														<select class = "form-control" id = "lcl_type" name="lcl_type" >
															@forelse($lcl_types as $lcl_type)
															<option value = "{{ $lcl_type->id }}">{{ $lcl_type->name }}</option>
															@empty
															@endforelse
														</select>
														
													</div>

												</td>
												<td width = "20%">

													<div class = "form-group " >
														
														<select class = "form-control" id = "basis_type" name="basis_type" >
															@forelse($basis_types as $basis_type)
															<option value = "{{ $basis_type->id }}">{{ $basis_type->abbreviation }}</option>
															@empty
															@endforelse
														</select>
														
													</div>

												</td>
												<td width = "40%">
													<div class = "input-group " >
														<span class = "input-group-addon">Php</span>
														<input type = "text" class = "form-control amount_valid "
														value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/>
													</div>

												</td>
												<td width = "10%" style="text-align: center;">
													<button class = "btn btn-danger btn-md delete-wf-row">x</button>
												</td>
												
											</tr>
										</table>
										<div class = "form-group" style = "margin-left:10px">
											<button    class = "btn btn-primary btn-md new-wf-row pull-left">New</button>
											<br /><br/>
											<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
										</div>
									</div>
								</div>					
							</div>
						</div>
						<div class="modal-footer">
							<button id = "btnSave" type = "submit" class="btn btn-success finalize-wf">Save</button>
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
.class-wf-fee
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

	var basis_type= [];
	var lcl_type= [];
	var amount_value = [];
	var data, tblLength;
	var jsonBasisType, jsonAmount;
	var arr_basis_type_id = [];
	var arr_lcl_type_id = [];

	
	$(document).ready(function(){
		var wf_row = "<tr>" + $('#wf-row').html() + "</tr>";

		var wftable = $('#wf_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			'scrollx': true,
			ajax: 'http://localhost:8000/admin/af_lcl_Data',
			columns: [
			{ data: 'location' },
			{ data: 'lcl_type',
			"render": function(data, type, row){
				return data.split(",").join("<br/>");}
			},
			{ data: 'basis_type',
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
			$('#amount').val("0.00");
			$('#wf_parent_table > tbody').html("");
			$('.modal-title').text('New Arrastre Fee Per Pier');
			$('#wfModal').modal('show');
			$('#wf_parent_table > tbody').append(wf_row);
			$('#wf_warning').removeClass('in');


		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('.modal-title').text('Update Arrastre Fee Per Pier');
			var wf_id = $(this).val();
			data = wftable.row($(this).parents()).data();
			
			$('#wfModal').modal('show');

			$.ajax({
				type: 'GET',
				url:  '{{ route("af_lcl_maintain_data") }}',
				data: {
					'_token' : $('input[name=_token').val(),
					'af_id' : $(this).val(),
				},
				success: function (data)
				{
					var rows = "";
					for(var i = 0; i < data.length; i++){

						rows += '<tr id = "wf-row"><td><div class = "form-group input-group" ><input type="hidden" class = "form-control" id = "lcl_type" name = "lcl_type" data-rule-required="true"  disabled = "true" value ="'+data[i].lcl_types_id+'" ><input   class = "form-control" id = "lcl_type_name" name = "lcl_type_name" data-rule-required="true"  disabled = "true" value ="'+data[i].lcl_type+'" ></div><div class = "form-group input-group" ></td></div><td><div class = "form-group input-group" ><input type="hidden" class = "form-control" id = "basis_type" name = "basis_type" data-rule-required="true"  disabled = "true" value ="'+data[i].basis_types_id+'" ><input   class = "form-control" id = "basis_type_name" name = "basis_type_name" data-rule-required="true"  disabled = "true" value ="'+data[i].basis_type+'" ></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control amount_valid" value ="'+data[i].amount+'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td><td width = "10%" style="text-align: center;"><button class = "btn btn-danger btn-md delete-wf-row">x</button></td></tr>';

					}
					$('#wf_parent_table > tbody').html("");
					$('#wf_parent_table > tbody').append(rows);

				}

			})
		});
		$(document).on('click', '.deactivate', function(e){
			var wf_id = $(this).val();
			data = wftable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});
		
		
		
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

				if($(this).val() > 0){
					$(this).css('border-color', 'green');
					$('#wf_warning').removeClass('in');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})

		$(document).on('click', '.delete-wf-row', function(e){
			e.preventDefault();
			$('#wf_warning').removeClass('in');
			if($('#wf_parent_table > tbody > tr').length == 1){
				$(this).closest('tr').remove();
				$('#wf_table_warning').addClass('fade in');
			}
			else{
				$(this).closest('tr').remove();
			}
		})

		$(document).on('click', '.new-wf-row', function(e){
			e.preventDefault();
			$('#wf_table_warning').removeClass('fade in');
			if(validatewfRows() === true){
				$('#wf_parent_table').append(wf_row);

			}
		})
		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/arrastre_fee_lcl/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					wftable.ajax.reload();
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
		$(document).on('click', '.finalize-wf', function(e){
			e.preventDefault();
			if(finalvalidateWfRows() === true){

				var title = $('.modal-title').text();
				console.log(title);
				if(title === "New Arrastre Fee Per Pier")
				{
					console.log("lcl is "+lcl_type_id);
					console.log("basis is "+basis_type_id);
					console.log("amount is "+amount_value);

					jsonLclType = JSON.stringify(lcl_type_id);
					jsonBasisType = JSON.stringify(basis_type_id);
					jsonAmount = JSON.stringify(amount_value);

					$.ajax({
						type: 'POST',
						url:  '/admin/arrastre_fee_lcl/',
						data: {
							'_token' : $('input[name=_token]').val(),
							'locations_id' : $('#locations_id').val(),
							'lcl_types_id':jsonLclType,
							'basis_types_id' : jsonBasisType,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
						},
						success: function (data){

							wftable.ajax.reload();
							$('#wfModal').modal('hide');
							$('.modal-title').text('New Arrastre Fee Per Pier');
							
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



					
					jsonBasisType = JSON.stringify(basis_type_id);
					jsonAmount = JSON.stringify(amount_value);
					jsonLclType = JSON.stringify(lcl_type_id);


					$.ajax({
						type: 'PUT',
						url:  '/admin/arrastre_fee_lcl/'+ data.id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'af_head_id': data.id,
							'locations_id' : $('#locations_id').val(),
							'lcl_types_id':jsonLclType,
							'basis_types_id' : jsonBasisType,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
							
						},
						success: function (data){

							wftable.ajax.reload();
							$('#wfModal').modal('hide');
							$('.modal-title').text('New Arrastre Fee Per Pier');
							
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

function validatewfRows()
{
	lcl_type_id = [];
	basis_type_id = [];
	amount_value = [];
	range_pairs = [];
	
	lcl_type = document.getElementsByName('lcl_type');
	basis_type = document.getElementsByName('basis_type');
	amount = document.getElementsByName('amount');
	error = "";


	if($(locations_id).val() === 0){
		dateEffective.style.borderColor = 'red';
		error += "Location is required.";
	}
	for(var i = 0; i < basis_type.length; i++){
		var temp;

		if(basis_type[i].value === "0")
		{
			basis_type[i].style.borderColor ='red';
			error+= "Basis required";
		}else
		{
			basis_type[i].style.borderColor = 'green';
			lcl_type_id.push(lcl_type[i].value);
			basis_type_id.push(basis_type[i].value);
			$('#wf_warning').removeClass('in');

		}
		
		if(amount[i].value === ""||amount[i].value === "0.00"||amount[i].value === "0")
		{
			amount[i].style.borderColor = 'red';
			error += "Amount Required.";
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
				$('#wf_warning').removeClass('in');
			}
		}
		
		pair = {
			amount: amount[i].value,
			basis_type: basis_type[i].value,
			lcl_type: lcl_type[i].value
		};
		range_pairs.push(pair);

	}

	var i, j, n;
	found= false;
	n=range_pairs.length;
	for (i=0; i<n; i++) {
		for (j=i+1; j<n; j++)
		{
			if (range_pairs[i].amount === range_pairs[j].amount && range_pairs[i].basis_type === range_pairs[j].basis_type && range_pairs[i].lcl_type === range_pairs[j].lcl_type){
				found = true;

				lcl_type[i].style.borderColor = 'red';
				lcl_type[j].style.borderColor = 'red';
				basis_type[i].style.borderColor = 'red';
				basis_type[j].style.borderColor = 'red';
				amount[i].style.borderColor = 'red';
				amount[j].style.borderColor = 'red';
				$('#wf_warning').addClass('in');

			}else{
				$('#wf_warning').removeClass('in');
			}
		}
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


	function finalvalidateWfRows()
	{
		lcl_type_id = [];
		basis_type_id = [];
		amount_value = [];
		range_pairs = [];
		lcl_type = document.getElementsByName('lcl_type');
		basis_type = document.getElementsByName('basis_type');
		amount = document.getElementsByName('amount');

		error = "";

		for(var i = 0; i < amount.length; i++){


			if(amount[i].value === ""||amount[i].value === "0.00"||amount[i].value === "0")
			{
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
				$('#wf_warning').addClass('in');
			}
			else
			{
				if(amount[i].value < 0){
					amount[i].style.borderColor = 'red';
					error += "Amount Required.";
				}
				else{
					amount[i].style.borderColor = 'green';
					var amounty = amount[i].value;
					console.log('amounty is' +amounty);
					//var temp = $('amounty').inputmask('unmaskedvalue');
					var temp = amounty;
					lcl_type_id.push(lcl_type[i].value);
					basis_type_id.push(basis_type[i].value);
					amount_value.push(temp);
					$('#wf_warning').removeClass('in');
				}
			}


			pair = {
				amount: amount[i].value,
				lcl_type: lcl_type[i].value,
				basis_type: basis_type[i].value
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		found= false;
		n=range_pairs.length;
		for (i=0; i<n; i++) {
			for (j=i+1; j<n; j++)
			{
				if (range_pairs[i].amount === range_pairs[j].amount && range_pairs[i].basis_type === range_pairs[j].basis_type && range_pairs[i].lcl_type === range_pairs[j].lcl_type){
					found = true;

					lcl_type[i].style.borderColor = 'red';
					lcl_type[j].style.borderColor = 'red';
					basis_type[i].style.borderColor = 'red';
					basis_type[j].style.borderColor = 'red';
					amount[i].style.borderColor = 'red';
					amount[j].style.borderColor = 'red';
					$('#wf_warning').addClass('in');

				}else{
					$('#wf_warning').removeClass('in');
				}
			}
		}
		
		if(error.length == 0){
			tblLength = basis_type.length;
			return true;
		}
		else
		{
			return false;
			btnSave.disabled('true');
		}

	}
	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush