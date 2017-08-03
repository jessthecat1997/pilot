@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Standard Area Rates</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#sarModal" style = "width: 100%;">New Standard Area Rates</button>
		</div>
	</div>
	<h4>Default pick-up location is pier </h4>
	<br />

	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "sar_table">
					<thead>
						<tr>
							<td>
								Date Effective
							</td>
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
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<section class="content">

	<form role="form" method = "POST" class="commentForm">
		<div class="modal fade" id="sarModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Standard Area Rate</h4>
						</div>
						<div class="modal-body ">		
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Date Effective:</label>
								<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date" data-rule-required="true">
							</div>
						</form>
						<br />
						<div class = "collapse" id = "sar_table_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one import processing fee rate.
							</div>
						</div>
						<div class = "collapse" id = "sar_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the range.
							</div>
						</div>
						<div class = "panel panel-default">
							<div  style="overflow-x: auto;">
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "sar_form" class = "commentForm">
										<table class="table responsive table-hover" width="100%" id= "sar_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
											<thead>
												<tr id = "contract-row">
													<td>
														<select name = "areas_id_from" id = "areas_id_from" class = "form-control area_from_valid" required = "true">
															<option></option>
															@forelse($areas as $area)
															<option value = "{{ $area->id }}">
																{{ $area->description }}
															</option>
															@empty

															@endforelse
														</select>
													</td>
													<td>
														<select name = "areas_id_to" id = "areas_id_to" class = "form-control area_to_valid" required="true">
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
														<input type = "number" name = "amount" class = "form-control amount_valid" style="text-align: right">

													</td>
													<td style="text-align: center;">
														<button class = "btn btn-danger btn-md delete-contract-row">x</button>
													</td>
												</tr>
											</table>
											<div class = "form-group" style = "margin-left:10px">
												<button    class = "btn btn-primary btn-md new-sar-row pull-left">New Standard Rate</button>
												<br /><br />
											</div>
										</div>
									</div>
								</div>

							</div>
							<div class="modal-footer">
								<button id = "btnSave" type = "submit" class="btn btn-success finalize-sar">Save</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>			
							</div>
						</div>
					</div>
				</div>
			</form>
			<br />
		</div>
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


</style>
@endpush
@push('scripts')
<script type="text/javascript">
	var from_id = [];
	var to_id = [];
	var amount_value = [];
	var amount_value_descrp = [];
	var from_id_descrp = [];
	var to_id_descrp = [];


	var data;
	$(document).ready(function(){
		var sar_row = "<tr>" + $('#sar-row').html() + "</tr>";
		$('#collapse1').addClass('in');

		
		//$(location).attr("disabled", true);

		var sartable = $('#sar_table').DataTable({
			processing: true,
			serverSide: true,
			'scrollx': true,
			ajax: 'http://localhost:8000/admin/sarData',
			columns: [

			{ data: 'dateEffective' },
			{ data: 'areaFrom'},
			{ data: 'areaTo'},
			{ data: 'location'},
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
				areaTo

				
			},
			onkeyup: false, 
			submitHandler: function (form) {
				return false;
			}
		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Standard Area Rate');
			$('#dateEffective').val("");
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
			$('#dateEffective').val(today);

			$('#sarModal').modal('show');

		});

		$(document).on('click', '.edit',function(e){
			resetErrors();
			
			var sar_id = $(this).val();
			
			$('.modal-title').text('New Standard Area Rate');
			$('#sarModal').modal('show');
		});

		$(document).on('click', '.deactivate', function(e){
			var sar_id = $(this).val();
			data = sartable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$(document).on('click', '.delete-sar-row', function(e){
			e.preventDefault();
			$('#sar_warning').removeClass('in');
			if($('#sar_parent_table > tbody > tr').length == 1){
				$(this).closest('tr').remove();
				$('#sar_table_warning').addClass('fade in');
			}
			else{
				$(this).closest('tr').remove();
			}
		})

		$(document).on('click', '.new-sar-row', function(e){
			e.preventDefault();
			$('#sar_table_warning').removeClass('fade in');
			if(validatesarRows() === true){

				$('#sar_parent_table').append(sar_row);

				
			}

		})

		$(document).on('change', '.sar_location_valid', function(e){
			$(".sar_location_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');

				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})

		$(document).on('change', '.sar_location_valid', function(e){
			$(".sar_location_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');


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
				url:  '/admin/sar_fee/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					sartable.ajax.reload();
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

		$(document).on('click', '.finalize-sar', function(e){
			e.preventDefault();

			if(finalvalidatesarRows() === true){
				
				var title = $('.modal-title').text();
				if(title == "New Standard Area Rate")
				{
					
					$.ajax({
						type: 'POST',
						url:  '/admin/sar_fee',
						data: {
							'_token' : $('input[name=_token]').val(),
							'dateEffective' : $('#dateEffective').val(),
							'location' : location_id,
							'location_id_descrp' : location_id_descrp,

							'amount' : amount_value,
						},

						success: function (data){

							

							sartable.ajax.reload();
							$('#sarModal').modal('hide');
							$('.modal-title').text('New Standard Area Rate');
							$('#location').val("0.00");
							$('#maximum').val("0.00"); 
							$('#amount').val("0.00");
							$('#dateEffective').val("");


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
				}
			}
		});
	});





function validatesarRows()
{

	location_id = [];
	maximum_id = [];
	amount_value = [];

	location_id_descrp = [];
	maximum_id_descrp = [];
	amount_value_descrp = [];

	range_pairs = [];
	dateEffective = document.getElementsByName('dateEffective');
	location =  document.getElementsByName('location');
	maximum =   document.getElementsByName('maximum');
	amount =  document.getElementsByName('amount');
	error = "";

	if(dateEffective === ""){

		dateEffective.style.borderColor = 'red';	
		error += "Date Effective Required.";

	} 


	for(var i = 0; i < location.length; i++){
		var temp;




		if(maximum[i].value === "")
		{
			maximum[i].style.borderColor = 'red';
			error += "Maximum Required.";
		}

		else
		{
			maximum[i].style.borderColor = 'green';
			maximum_id_descrp.push(maximum[i].value);
			maximum_id.push(maximum[i].value);
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
			}
		}

		if(location[i].value === maximum[i].value){

			maximum[i].style.borderColor = 'red';
			error += "Same.";
		}

		if(location[i].value>maximum[i].value){
			
			maximum[i].style.borderColor = 'red';
			error += "location is greater than maximum";
			$('#sar_warning').addClass('in');
		}	

		pair = {
			location: location[i].value,
			maximum : maximum[i].value
		};
		range_pairs.push(pair);
	}
	var i, j, n;
	found= false;
	n=range_pairs.length;

	for (i=0; i<n; i++) {                        
		for (j=i+1; j<n; j++)
		{              
			if (range_pairs[i].location === range_pairs[j].maximum && range_pairs[i].maximum === range_pairs[j].maximum){
				found = true;
				
				maximum[i].style.borderColor = 'red';

				location[j].style.borderColor = 'red';
				maximum[j].style.borderColor = 'red';
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

	function finalvalidatesarRows()
	{
		location_id = [];
		maximum_id = [];
		amount_value = [];

		location_id_descrp = [];
		maximum_id_descrp = [];
		amount_value_descrp = [];

		range_pairs = [];

		location = document.getElementsByName('location');
		maximum = document.getElementsByName('maximum');
		amount = document.getElementsByName('amount');
		
		error = "";

		if($('#dateEffective').val() == ""){

			document.getElementById("dateEffective").style.borderColor = "red";
			error += "Date Effective Required.";

		}else{
			document.getElementById("dateEffective").style.borderColor = "black";

		}

		for(var i = 0; i < location.length; i++){


			if(location[i].value === "")
			{

				error += "location Required.";
				$('#sar_warning').addClass('in');
			}

			else
			{

				location_id_descrp.push(location[i].value);
				var min = location[i].value
				location_id.push(location[i].value);
			}
			if(maximum[i].value === ""||maximum[i].value === "0.00"||maximum[i].value === "0")
			{
				maximum[i].style.borderColor = 'red';
				error += "Maximum Required.";
				$('#sar_warning').addClass('in');
			}

			else
			{
				maximum[i].style.borderColor = 'green';
				maximum_id_descrp.push(maximum[i].value);
				maximum_id.push(maximum[i].value);
			}

			if(amount[i].value === ""||amount[i].value === "0.00"||amount[i].value === "0")
			{
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
				$('#contract_rates_warning').addClass('in');
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
				}
			}

			if(location[i].value === maximum[i].value){

				maximum[i].style.borderColor = 'red';
				error += "Same.";
				$('#sar_warning').addClass('in');
			}

			if(location[i].value>maximum[i].value){

				maximum[i].style.borderColor = 'red';
				error += "location is greater than maximum";
				$('#sar_warning').addClass('in');
			}	
			pair = {
				location: location[i].value,
				maximum: maximum[i].value
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		found= false;
		n=range_pairs.length;
		for (i=0; i<n; i++) {                        
			for (j=i+1; j<n; j++)
			{              
				if (range_pairs[i].location === range_pairs[j].location && range_pairs[i].maximum === range_pairs[j].maximum){
					found = true;
					
					maximum[i].style.borderColor = 'red';


					maximum[j].style.borderColor = 'red';
				}
			}	
		}
		if(found == true){
			error+= "Existing rate.";
			$('#sar_warning').addClass('in');
		}

		if(error.length == 0){
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