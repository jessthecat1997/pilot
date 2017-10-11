@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Less Cargo Load Arrastre Fee</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#afModal" style = 'width: 100%;'>New Less Cargo Load Arrastre Fee </button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped cell-border table-bordered" id = "af_table">
					<thead>
						<tr>
							<td>
								Date Effective
							</td>
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
					<tbody>
						@forelse($arrastres as $a)
						<tr>
							<td>
								{{ Carbon\Carbon::parse($a->dateEffective)->format("F d, Y") }}
							</td>
							<td>
								{{ $a->location}}
							</td>
							<td>
								{{ $a->lcl_type}}
							</td>
							<td>
								{{ $a->basis_type}}
							</td>
							<td>
								{{ $a->amount}}
							</td>
							<td>
								<button value = "{{ $a->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $a->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								<input type = "hidden" class = "date_effective" value = "{{$a->dateEffective}}">
							</td>
						</tr>
						@empty
						@endforelse
					</tbody>
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
							<h4 class="modal-title">New Less Cargo Load Arrastre Fee per Location</h4>
						</div>
						<div class="modal-body ">
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Date Effective:</label>
								<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date" data-rule-required="true">
							</div>
							<div class="form-group required">
								<label class="control-label " for="location">Location Pier:</label>
								<select class = "form-control" id = "locations_id" placeholder ="Choose a pier location">
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
								<strong>Warning!</strong> Requires at least one Arrastre free per container.
							</div>
						</div>
						<div class = "collapse" id = "af_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the Arrastre fees.
							</div>
						</div>
						<div class = "panel panel-default">
							<div>
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "Arrastre_form" class = "commentForm">
										<table class="table responsive table-hover"  id= "af_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
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
											<tr id = "af-row">
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
														<input type = "text" class = "form-control money amount_valid "
														value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/>
													</div>

												</td>
												<td width = "10%" style="text-align: center;">
													<button class = "btn btn-danger btn-md delete-af-row">x</button>
												</td>

											</tr>
										</table>
										<div class = "form-group" style = "margin-left:10px">
											<button    class = "btn btn-primary btn-md new-af-row pull-left">New</button>
											<br /><br/>
											<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
										</div>
									</div>
								</div>
							</div>
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
.class-af-fee-lcl
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
	$('#arrastrecollapse').addClass('in');
	$('#collapse2').addClass('in');

	var basis_type= [];
	var lcl_type= [];
	var amount_value = [];
	var data, tblLength;
	var jsonBasisType, jsonAmount;
	var arr_basis_type_id = [];
	var arr_lcl_type_id = [];
	var af_id;
	var data;

	$(document).ready(function(){
		var now = new Date();
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

		var af_row = "<tr>" + $('#af-row').html() + "</tr>";

		var aftable = $('#af_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			'scrollx': true,
			"bSort": false,
			columns: [
			{ data: 'dateEffective'},
			{ data: 'location' },
			{ data: 'lcl_type',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'basis_type',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'amount',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},

			{ data: 'action', orderable: false, searchable: false }

			],
		});
		$("#commentForm").validate({
			rules:
			{
				dateEffective:
				{
					required: true,
				},
				locations_id:
				{
					required: true,
				},
				basis_type:
				{
					required:true,
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
			$('#af_warning').removeClass('in');
			$('#amount').val("0.00");
			$('#dateEffective').val(today);
			$('#af_parent_table > tbody').html("");
			$('.modal-title').text('New Less Cargo Load Arrastre Fee per Location');
			$('#afModal').modal('show');
			$('#af_parent_table > tbody').append(af_row);
			
			
			$('.money').inputmask("numeric", {
				radixPoint: ".",
				groupSeparator: ",",
				digits: 2,
				autoGroup: true,
				rightAlign: true,
				removeMaskOnSubmit:true,
			});


		});




		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('.modal-title').text('Update Less Cargo Load Arrastre Fee per Location');
			af_id = $(this).val();
			data = aftable.row($(this).parents()).data();
			$("#locations_id option").filter(function(index) { return $(this).text() === data.location; }).attr('selected', 'selected');
			$('#locations_id').attr('disabled','true');
			$('#dateEffective').val($(this).closest('tr').find('.date_effective').val());
			$('#afModal').modal('show');

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

						rows += '<tr id = "af-row"><td><div class = "form-group input-group" ><input type="hidden" class = "form-control" id = "lcl_type" name = "lcl_type" data-rule-required="true"  disabled = "true" value ="'+data[i].lcl_types_id+'" ><input   class = "form-control" id = "lcl_type_name" name = "lcl_type_name" data-rule-required="true"  disabled = "true" value ="'+data[i].lcl_type+'" ></div><div class = "form-group input-group" ></td></div><td><div class = "form-group input-group" ><input type="hidden" class = "form-control" id = "basis_type" name = "basis_type" data-rule-required="true"  disabled = "true" value ="'+data[i].basis_types_id+'" ><input   class = "form-control" id = "basis_type_name" name = "basis_type_name" data-rule-required="true"  disabled = "true" value ="'+data[i].basis_type+'" ></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control money amount_valid" value ="'+numberWithCommas(data[i].amount)+'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td><td width = "10%" style="text-align: center;"><button class = "btn btn-danger btn-md delete-af-row">x</button></td></tr>';

					}
					$('#af_parent_table > tbody').html("");
					$('#af_parent_table > tbody').append(rows);
					$('.money').inputmask("numeric", {
						radixPoint: ".",
						groupSeparator: ",",
						digits: 2,
						autoGroup: true,
						rightAlign: true,
						removeMaskOnSubmit:true,
					});

				}

			})
			
		});
		$(document).on('click', '.deactivate', function(e){
			af_id = $(this).val();
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
			
			if(validateafRows() === true){
				$('#af_parent_table').append(af_row);
				$('#af_table_warning').removeClass('fade in');

			}
		})
		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/arrastre_fee_lcl/' + af_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					aftable.ajax.url( '{{ route("af_lcl.data") }}' ).load();
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

			if(finalvalidateafRows() === true){

				var title = $('.modal-title').text();
				console.log(title);
				if(title === "New Less Cargo Load Arrastre Fee per Location")
				{
					if($('#dateEffective').valid() && $('#locations_id').valid() && $('#basis_type').valid())
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
								'dateEffective':$('#dateEffective').val(),
								'locations_id' : $('#locations_id').val(),
								'lcl_types_id':jsonLclType,
								'basis_types_id' : jsonBasisType,
								'amount' : jsonAmount,
								'tblLength' : tblLength,
							},
							success: function (data){
								console.log(typeof(data));
								if(typeof(data) === "object"){

									aftable.ajax.url( '{{ route("af_lcl.data") }}' ).load();
									$('#afModal').modal('hide');
									$('.modal-title').text('New Less Cargo Load Arrastre Fee per Location');

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
									toastr["success"]("Record pd successfully")
									$('#btnSave').removeAttr('disabled');
								}else{
									e.preventDefault();
									resetErrors();
									var invdata = JSON.parse(data);
									$.each(invdata, function(i, v) {
										console.log(i + " => " + v);
										var msg = '<label class="error" for="'+i+'">'+v+'</label>';
										$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
									});

									$('#btnSave').removeAttr('disabled');
								}

							}
						})
					}

				}else{


					if($('#dateEffective').valid() && $('#locations_id').valid() && $('#basis_type').valid()){

						

						jsonBasisType = JSON.stringify(basis_type_id);
						jsonAmount = JSON.stringify(amount_value);
						jsonLclType = JSON.stringify(lcl_type_id);


						$.ajax({
							type: 'PUT',
							url:  '/admin/arrastre_fee_lcl/'+ af_id,

							data: {
								'_token' : $('input[name=_token]').val(),
								'af_head_id': af_id,
								'locations_id' : $('#locations_id').val(),
								'dateEffective':  $('#dateEffective').val(),
								'lcl_types_id':jsonLclType,
								'basis_types_id' : jsonBasisType,
								'amount' : jsonAmount,
								'tblLength' : tblLength,

							},
							
							success: function (data){
								console.log(typeof(data));
								if(typeof(data) == "object"){
									aftable.ajax.url( '{{ route("af_lcl.data") }}' ).load();
									$('#afModal').modal('hide');
									$('.modal-title').text('New Less Cargo Load Arrastre Fee per Location');

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
									$('#btnSave').removeAttr('disabled');
								}else{
									resetErrors();
									var invdata = JSON.parse(data);
									$.each(invdata, function(i, v) {
										console.log(i + " => " + v);
										var msg = '<label class="error" for="'+i+'">'+v+'</label>';
										$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
									});

									$('#btnSave').removeAttr('disabled');
								}

							}
						})


					}



				}
			}
		});


function validateafRows()
{
	lcl_type_id = [];
	basis_type_id = [];
	amount_value = [];
	range_pairs = [];

	lcl_type = document.getElementsByName('lcl_type');
	basis_type = document.getElementsByName('basis_type');
	amount = document.getElementsByName('amount');
	error = "";
	var amt;

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
			$('#af_warning').removeClass('in');

		}
		amt = parseFloat(amount[i].value);

		if(amt < 0){
			amount[i].style.borderColor = 'red';
			error += "Amount Required.";
		}
		else{
			amount[i].style.borderColor = 'green';
			amount_value.push($(amount[i]).inputmask('unmaskedvalue'));
			$('#af_warning').removeClass('in');
		}


		pair = {

			lcl_type: lcl_type[i].value,
			basis_type: basis_type[i].value,
		};
		range_pairs.push(pair);

	}

	var i, j, n;
	found= false;
	n=range_pairs.length;
	for (i=0; i<n; i++) {
		for (j=i+1; j<n; j++)
		{
			if (range_pairs[i].lcl_type === range_pairs[j].lcl_type && range_pairs[i].basis_type === range_pairs[j].basis_type){
				found = true;

				lcl_type[i].style.borderColor = 'red';
				lcl_type[j].style.borderColor = 'red';
				basis_type[i].style.borderColor = 'red';
				basis_type[j].style.borderColor = 'red';

				$('#af_warning').addClass('in');
				error += "Same LCL";
			}else{
				$('#af_warning').removeClass('in');
				lcl_type[i].style.borderColor = 'green';
				lcl_type[j].style.borderColor = 'green';
				basis_type[i].style.borderColor = 'green';
				basis_type[j].style.borderColor = 'green';

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


	function finalvalidateafRows()
	{
		lcl_type_id = [];
		basis_type_id = [];
		amount_value = [];
		range_pairs = [];
		lcl_type = document.getElementsByName('lcl_type');
		basis_type = document.getElementsByName('basis_type');
		amount = document.getElementsByName('amount');
		var amt;
		error = "";

		for(var i = 0; i < amount.length; i++){

			amt = parseFloat(amount[i].value);
			if(amt < 0){
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
				$('#af_warning').addClass('in');
			}
			else{
				amount[i].style.borderColor = 'green';

				lcl_type_id.push(lcl_type[i].value);
				basis_type_id.push(basis_type[i].value);
				amount_value.push($(amount[i]).inputmask('unmaskedvalue'));
				$('#af_warning').removeClass('in');
			}
			


			pair = {
				
				lcl_type: lcl_type[i].value,
				
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		found= false;
		n=range_pairs.length;
		for (i=0; i<n; i++) {
			for (j=i+1; j<n; j++)
			{
				if(range_pairs[i].lcl_type === range_pairs[j].lcl_type && range_pairs[i].basis_type === range_pairs[j].basis_type){
					found = true;

					lcl_type[i].style.borderColor = 'red';
					lcl_type[j].style.borderColor = 'red';
					basis_type[i].style.borderColor = 'red';
					basis_type[j].style.borderColor = 'red';

					$('#af_warning').addClass('in');
					error += "Same LCL";
				}else{
					$('#af_warning').removeClass('in');
					lcl_type[i].style.borderColor = 'green';
					lcl_type[j].style.borderColor = 'green';
					basis_type[i].style.borderColor = 'green';
					basis_type[j].style.borderColor = 'green';

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
});
function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush
