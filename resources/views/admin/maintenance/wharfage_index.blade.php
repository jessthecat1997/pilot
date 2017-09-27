
@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Containerized Wharfage Fee</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#wfModal" style = 'width: 100%;'>New Wharfage</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "wf_table">
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
								Wharfage Fee Amount
							</td>
							
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
					@forelse($wharfages as $w)
						<tr>
							<td>
								{{ Carbon\Carbon::parse($w->dateEffective)->format("F d, Y") }}
							</td>
							<td>
								{{ $w->location}}
							</td>
							<td>
								{{ $w->container_size}}
							</td>
							<td>
								{{ $w->amount}}
							</td>
							<td>
								<button value = "{{ $w->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $w->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
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
		<div class="modal fade" id="wfModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Wharfage Fee Per Pier</h4>
						</div>
						<div class="modal-body ">
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
						<div class = "collapse" id = "wf_table_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one wharfage free per container.
							</div>
						</div>
						<div class = "collapse" id = "wf_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the Wharfage fees.
							</div>
						</div>
						<div class = "panel panel-default">
							<div  style="overflow-x: auto;">
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "wharfage_form" class = "commentForm">
										<table class="table responsive table-hover" width="100%" id= "wf_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
											<thead>
												<tr>
													<td width="5%">
														<div class="form-group required">
															<label class = "control-label"><strong>Container Size</strong></label>
														</div>
													</td>

													<td width="10%">
														<div class="form-group required">
															<label class = "control-label"><strong>Wharfage Fee</strong></label>
														</div>
													</td>
													
												</tr>
											</thead>
											<tr id = "wf-row">
												<td>

													<div class = "form-group input-group" >
														
														<input type = "text" class = "form-control  wf_container_size_valid"
														value ="" name = "container_size" id = "container_size"  data-rule-required="true" disabled style="text-align: right;"/><span class = "input-group-addon">-footer</span>
														
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

	var container_size= [];
	var amount_value = [];
	var data, tblLength;
	var jsonContainerSize, jsonAmount;
	var arr_container_size_id = [];
	var arr_container_size_name = [];
	@forelse($sizes as $size)
	arr_container_size_name.push({{ $size->name }});
	arr_container_size_id.push({{ $size->id }});
	@empty
	@endforelse

	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;


	var wf_id;

	$(document).ready(function(){



		var wf_row = "<tr>" + $('#wf-row').html() + "</tr>";

		var wftable = $('#wf_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			'scrollx': true,
			columns: [
			{ data: 'dateEffective'},
			{ data: 'location' },
			{ data: 'container_size',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
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
					date:true,
				},
				locations_id:
				{
					required: true,
				}
			},
			onkeyup: false,
			submitHandler: function (form) {
				return false;
			}
		});
		$(document).on('click', '.new', function(e){
			e.preventDefault();
			resetErrors();
			$('#dateEffective').val(today);
			$('#amount').val("0.00");

			$('#wf_parent_table > tbody').html("");
			var rows = "";
			for(var i = 0; i < arr_container_size_id.length; i++){

				rows += '<tr id = "wf-row"><td><div class = "form-group input-group" ><input  type = "hidden" class = "form-control wf_container_size_valid" id = "container_size" name = "container_size" data-rule-required="true"  disabled = "true "value ="'+arr_container_size_id[i]+'" ><input class = "form-control wf_container_size_valid" id = "container_size_name" name = "container_size_name" data-rule-required="true"  disabled = "true "value ="'+arr_container_size_name[i]+'" ><span class = "input-group-addon">-footer</span></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control amount_valid" value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td></tr>';

			}
			$('.modal-title').text('New Wharfage Fee Per Pier');
			$('#wfModal').modal('show');
			
			$('#wf_parent_table > tbody').append(rows);


		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('.modal-title').text('Update Wharfage Fee Per Pier');
			wf_id = $(this).val();
			data = wftable.row($(this).parents()).data();
			
			$("#locations_id option").filter(function(index) { return $(this).text() === data.location; }).attr('selected', 'selected');
			$('#dateEffective').val(data.dateEffective);

			$('#wfModal').modal('show');

			$.ajax({
				type: 'GET',
				url:  '{{ route("wf_maintain_data") }}',
				data: {
					'_token' : $('input[name=_token').val(),
					'wf_id' : $(this).val(),
				},
				success: function (data)
				{
					var rows = "";
					for(var i = 0; i < data.length; i++){

						rows += '<tr id = "wf-row"><td><div class = "form-group input-group" ><input type="hidden" class = "form-control" id = "container_size" name = "container_size" data-rule-required="true"  disabled = "true" value ="'+data[i].container_sizes_id+'" ><input   class = "form-control" id = "container_size_name" name = "container_size_name" data-rule-required="true"  disabled = "true" value ="'+data[i].container_size+'" ><span class = "input-group-addon">-footer</span></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control amount_valid" value ="'+data[i].amount+'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td></tr>';

					}
					$('#wf_parent_table > tbody').html("");
					$('#wf_parent_table > tbody').append(rows);

				}

			})
		});
		$(document).on('click', '.deactivate', function(e){
			wf_id = $(this).val();
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
		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/wharfage_fee/' + wf_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					wftable.ajax.url( '{{ route("wf.data") }}' ).load();
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
			if(finalvalidatewfRows() === true){

				var title = $('.modal-title').text();
				if(title == "New Wharfage Fee Per Pier")
				{
					if($('#dateEffective').valid() && $('#locations_id').valid()){

						$('#btnSave').attr('disabled', 'true');

						console.log(amount_value);
						jsonContainerSize = JSON.stringify(container_size_id);
						jsonAmount = JSON.stringify(amount_value);

						$.ajax({
							type: 'POST',
							url:  '/admin/wharfage_fee',
							data: {
								'_token' : $('input[name=_token]').val(),
								'dateEffective':$('#dateEffective').val(),
								'locations_id' : $('#locations_id').val(),
								'container_sizes_id' : jsonContainerSize,
								'amount' : jsonAmount,
								'tblLength' : tblLength,
							},
							success: function (data){

								wftable.ajax.url( '{{ route("wf.data") }}' ).load();
								$('#wfModal').modal('hide');
								$('.modal-title').text('New Wharfage Fee Per Pier');

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
								$('#btnSave').removeAttr('disabled');
							}
						})

					}
					
				}else{


					if($('#dateEffective').valid() && $('#locations_id').valid()){

						$('#btnSave').attr('disabled', 'true');

						jsonContainerSize = JSON.stringify(container_size_id);
						jsonAmount = JSON.stringify(amount_value);


						$.ajax({
							type: 'PUT',
							url:  '/admin/wharfage_fee/'+ wf_id,
							data: {
								'_token' : $('input[name=_token]').val(),
								'locations_id' : $('#locations_id').val(),
								'dateEffective':$('#dateEffective').val(),
								'container_sizes_id' : jsonContainerSize,
								'amount' : jsonAmount,
								'tblLength' : tblLength,
								'wf_head_id':wf_id,

							},
							success: function (data){
								console.log(data);
								wftable.ajax.url( '{{ route("wf.data") }}' ).load();
								$('#wfModal').modal('hide');
								$('.modal-title').text('New Wharfage Fee Per Pier');

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
							}
						})
					}

					


				}
			}
		});
	});
function validateIpfRows()
{
	
	container_size_id = [];
	amount_value = [];
	range_pairs = [];
	
	container_size = document.getElementsByName('container_size');
	amount = document.getElementsByName('amount');
	error = "";


	if($(locations_id).val() === 0){
		dateEffective.style.borderColor = 'red';
		error += "Location is required.";
	}
	for(var i = 0; i < container_size.length; i++){
		var temp;
		
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

				
				container_size_id.push(container_size[i].value);
				$('#wf_warning').removeClass('in');
			}
		}
		
		pair = {
			amount: amount[i].value,
			container_size: container_size[i].value
		};
		range_pairs.push(pair);
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

	function finalvalidatewfRows()
	{

		container_size_id = [];
		amount_value = [];
		range_pairs = [];
		container_size = document.getElementsByName('container_size');
		amount = document.getElementsByName('amount');

		error = "";



		for(var i = 0; i < container_size.length; i++){

			
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
					container_size_id.push(container_size[i].value);
					amount_value.push(temp);
					$('#wf_warning').removeClass('in');
				}
			}


			pair = {
				amount: amount[i].value,
				container_size: container_size[i].value
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		
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
