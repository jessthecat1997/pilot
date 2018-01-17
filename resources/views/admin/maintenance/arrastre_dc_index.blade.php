@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Containerized Dangerous Arrastre Fee</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#afModal" style = 'width: 100%;'>New Containerized Dangerous Cargo Arrastre Fee </button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped cell-border table-bordered" id = "af_table" style="width: 100%;">
					<thead>
						<tr>
							<td>
								Date Effective
							</td>
							<td>
								Location Pier
							</td>
							<td>
								Container Size
							</td>
							<td>
								Dangerous Cargo Type
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
								{{ $a->container_size}}
							</td>
							<td>
								{{ $a->dc_type}}
							</td>
							<td>
								{{ $a->amount}}
							</td>
							<td>
								<button value = "{{ $a->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">View</button>
								<button value = "{{ $a->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								<input type = "hidden" value = "{{ Carbon\Carbon::parse($a->dateEffective)->format('Y-m-d') }}"  class = "date_Effective" />
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
							<h4 class="modal-title">New Containerized Dangerous Cargo Arrastre Fee per Location</h4>
						</div>
						<div class="modal-body  ">
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Date Effective:</label>
								<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date" data-rule-required="true">
							</div>
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
													<td width="5%">
														<div class="form-group required">
															<label class = "control-label"><strong>Container Size</strong></label>
														</div>
													</td>

													<td width="5%">
														<div class="form-group required">
															<label class = "control-label"><strong>Dangerous Cargo Type</strong></label>
														</div>
													</td>


													<td width="10%">
														<div class="form-group required">
															<label class = "control-label"><strong>Arrastre Fee</strong></label>
														</div>
													</td>
													
												</tr>
											</thead>
											<tr id = "af-row">
												<td>

													<div class = "form-group input-group" >
														
														<input type = "text" class = "form-control  af_container_size_valid"
														value ="" name = "container_size" id = "container_size"  data-rule-required="true" disabled style="text-align: right;"/><span class = "input-group-addon">-footer</span>
														
													</div>

												</td>
												<td>
													<div class = "form-group input-group"  >
														<select name = "dc_types_id" id = "dc_types_id" class = "form-control select2-allow-clear dc_types_id" 
														style="width: 150px;" multiple="multiple">
														@forelse($dc_types as $dc)
														<option value="{{ $dc->id }}">{{ $dc->name }}</option>
														@empty
														@endforelse
													</select>
												</div>
											</td>
											<td>
												<div class = "form-group input-group " >
													<span class = "input-group-addon">Php</span>
													<input type = "text" class = "form-control money amount_valid"
													value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/>
												</div>

											</td>

										</tr>
									</table>

								</div>
							</div>					
						</div>
						<small style = "color:red; text-align: left"><i>All fields are required.</i></small>
					</div>
					<div class="modal-footer">
						<div class="collapse in" id = "sv_collapse">
							<button id = "btnSave" type = "submit" class="btn btn-success finalize-af">Save</button></div>
							<br/>
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
<link href= "/js/select2/select2.css" rel = "stylesheet">
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
	var dc_types_id = [];
	var amount_value = [];
	var dangerous_cargo_type = [];
	var data, tblLength;
	var jsonContainerSize, jsonAmount, jsonDC;
	var arr_container_size_id = [];
	var arr_container_size_name = [];
	var dc_arr, af_id;
	@forelse($sizes as $size)
	arr_container_size_name.push({{ $size->name }});
	arr_container_size_id.push({{ $size->id }});
	@empty
	@endforelse

	var arr_dc_types = [ 
	@forelse($dc_types as $dc_type) 
	{ id: '{{ $dc_type->id }}', text:'{{ $dc_type->name }}' }, 
	@empty 
	@endforelse  
	]; 

	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;



	$(document).ready(function(){


		$('.money').inputmask("numeric", {
			radixPoint: ".",
			groupSeparator: ",",
			digits: 2,
			autoGroup: true,
			rightAlign: true,
			removeMaskOnSubmit:true,
		});

		$('.dc_types').select2({
			placeholder: "Select Dangerous Cargo Types",
			allowClear: true
		});

		var af_row = "<tr>" + $('#af-row').html() + "</tr>";

		var aftable = $('#af_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'dateEffective'},
			{ data: 'location' },
			{ data: 'container_size',
			"render": function(data, type, row){
				return data.split(",").join("<br/>");}
			},
			{ data: 'dc_type',
			"render": function(data, type, row){
				return data.split(",").join("<br/>");}
			},
			{ data: 'amount',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
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
				dc_types_id:
				{

					required:true,
				}

			},
			onkeyup: false,
			submitHandler: function (form) {
				return false;
			}
		});

		$('.dc_types_id').select2({
			data: arr_dc_types ,
			placeholder: "Select Dangerous Cargo Types",
			allowClear: true
		});

		
		$(document).on('click', '.new', function(e){
			e.preventDefault();
			resetErrors();
			$('#amount').val("0.00");
			$('#sv_collapse').addClass('in');
			$('#af_parent_table > tbody').html("");
			var rows = "";
			for(var i = 0; i < arr_container_size_id.length; i++){

				rows += '<tr id = "af-row"><td><div class = "form-group input-group" ><input  type = "hidden" class = "form-control af_container_size_valid" id = "container_size" name = "container_size" data-rule-required="true"  disabled = "true "value ="'+arr_container_size_id[i]+'" ><input class = "form-control af_container_size_valid" id = "container_size_name" name = "container_size_name" data-rule-required="true"  disabled = "true "value ="'+arr_container_size_name[i]+'" ><span class = "input-group-addon">-footer</span> </div></td><td><div class = "form-group input-group"  ><select name = "dc_types_id" id = "dc_types_id" class = "form-control select2-allow-clear dc_types_id" style="width: 150px;" multiple="multiple"></select></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control money amount_valid" value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td></tr>';

			}
			

			$('.modal-title').text('New Containerized Dangerous Cargo Arrastre Fee per Location');
			$('#afModal').modal('show');
			$('#dateEffective').val(today);
			$('#af_parent_table > tbody').append(rows);

			$('.money').inputmask("numeric", {
				radixPoint: ".",
				groupSeparator: ",",
				digits: 2,
				autoGroup: true,
				rightAlign: true,
				removeMaskOnSubmit:true,
			});

			var arr_dc_types = [ 
			@forelse($dc_types as $dc_type) 
			{ id: '{{ $dc_type->id }}', text:'{{ $dc_type->name }}' }, 
			@empty 
			@endforelse  
			]; 

			$('.dc_types_id').select2({
				data: arr_dc_types ,
				placeholder: "Select Dangerous Cargo Types",
				allowClear: true
			});


		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('.modal-title').text('Update Arrastre Fee Per Pier');
			af_id = $(this).val();
			data = aftable.row($(this).parents()).data();
			$("#locations_id option").filter(function(index) { return $(this).text() === data.location; }).attr('selected', 'selected');
			$('#locations_id').attr('disabled','true');
			$('#dateEffective').val($(this).closest('tr').find('.date_Effective').val());
			$('#sv_collapse').removeClass('in');
			$('#afModal').modal('show');
			id = $(this).val();
			$.ajax({
				type: 'GET',
				url:  '{{ route("af_dc_maintain_data") }}',
				data: {
					'_token' : $('input[name=_token').val(),
					'af_id' : id,
				},
				success: function (data)
				{
					console.log(data);
					var rows = "";
					for(var i = 0; i < data.length; i++){

						rows += '<tr id = "af-row"><td><div class = "form-group input-group" ><input type="hidden" class = "form-control" id = "container_size" name = "container_size" data-rule-required="true"  disabled = "true" value ="'+ data[i].container_sizes_id +'" ><input type = "text"  class = "form-control" id = "container_size_name" name = "container_size_name" data-rule-required="true"  disabled = "true" value ="'+data[i].container_size+'" ><span class = "input-group-addon">-footer</span></div></td><td>' +data[i].dc_name + '<td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" readonly = "readonly" class = "form-control amount_valid" value ="'+data[i].amount+'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td></tr>';

					}
					$('#af_parent_table > tbody').html("");
					$('#af_parent_table > tbody').append(rows);

				}

			})

			$('.money').inputmask("numeric", {
				radixPoint: ".",
				groupSeparator: ",",
				digits: 2,
				autoGroup: true,
				rightAlign: true,
				removeMaskOnSubmit:true,
			});
		});
		$(document).on('click', '.deactivate', function(e){
			af_id = $(this).val();
			data = aftable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



		
		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/arrastre_fee_dc/' +af_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					aftable.ajax.url( '{{ route("af_dc.data") }}' ).load();
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
			if(finalvalidateAfRows() === true){

				var title = $('.modal-title').text();
				if(title == "New Containerized Dangerous Cargo Arrastre Fee per Location")
				{
					console.log(amount_value);
					console.log("dc is " + dangerous_cargo_type);
					jsonContainerSize = JSON.stringify(container_size_id);
					jsonAmount = JSON.stringify(amount_value);
					jsonDC = JSON.stringify(dc_arr);

					$.ajax({
						type: 'POST',
						url:  '/admin/arrastre_fee_dc',
						data: {
							'_token' : $('input[name=_token]').val(),
							'dateEffective': $('#dateEffective').val(),
							'locations_id' : $('#locations_id').val(),
							'container_sizes_id' : jsonContainerSize,
							'dc_types_id': jsonDC,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
						},
						success: function (data){
							aftable.ajax.url( '{{ route("af_dc.data") }}' ).load();
							$('#afModal').modal('hide');
							$('.modal-title').text('New Containerized Dangerous Cargo Arrastre Fee per Location');

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
							toastr["success"]("Record added successfully")

						}
					})
				}else{




					jsonContainerSize = JSON.stringify(container_size_id);
					jsonAmount = JSON.stringify(amount_value);
					jsonDC = JSON.stringify(dc_arr);

					$.ajax({
						type: 'PUT',
						url:  '/admin/arrastre_fee_dc/'+ af_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'dateEffective': $('#dateEffective').val(),
							'af_head_id': af_id,
							'locations_id' : $('#locations_id').val(),
							'dc_types_id': jsonDC,
							'container_size_id' : jsonContainerSize,
							'amount' : jsonAmount,
							'tblLength' : tblLength,

						},
						success: function (data){
							console.log(data);
							aftable.ajax.url( '{{ route("af_dc.data") }}' ).load();
							$('#afModal').modal('hide');
							$('.modal-title').text('New Containerized Dangerous Cargo Arrastre Fee per Location');

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


		function finalvalidateAfRows()
		{


			container_size_id = [];
			dangerous_cargo_type_id = [];
			amount_value = [];
			range_pairs = [];

			dangerous_cargo_type = document.getElementsByName('dc_types_id');
			container_size = document.getElementsByName('container_size');
			amount = document.getElementsByName('amount');
			error = "";
			var temp;
			var amt;

			if($(locations_id).val() === 0){
				dateEffective.style.borderColor = 'red';
				error += "Location is required.";
			}
			dc_arr = [];
			for(var i = 0; i < container_size.length; i++){

				console.log('dc issss' + dangerous_cargo_type[i].value);

				amt = parseFloat($(amount[i]).inputmask('unmaskedvalue'));
				

				$(dangerous_cargo_type[i]).each(function(j){
					selected = [];
					var obj = $(this);
					$(obj).find(':selected').each(function(k){
						selected.push($(this).val());
					})
					dc_arr.push(selected);
				})
				
				
				if(amt < 0)
				{
					amount[i].style.borderColor = 'red';
					error += "Amount Required.";
				}
				else
				{
					amount[i].style.borderColor = 'green';
					container_size_id.push(container_size[i].value);
					amount_value.push($(amount[i]).inputmask('unmaskedvalue'));
					$('#af_warning').removeClass('in');

				}
				console.log($(amount[i]).inputmask('unmaskedvalue'));
				pair = {
					amount: $(amount[i]).inputmask('unmaskedvalue'),
					container_size: container_size[i].value
				};
				range_pairs.push(pair);
			}
			console.log(dc_arr);
			console.log(dc_arr[0][0]);


		if(error.length == 0){

			return true;
		}
		else
		{
			return false;
		}
	}


});


function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush
