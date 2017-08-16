@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Standard Area Rates</h3>
			<hr>
			<div class = "col-md-3 col-md-offset-9">
				<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#sarModal" style = "width: 100%;">New Standard Area Rates</button>
			</div>
		</div>
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
									Standard Rate
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
							<div class = "panel-heading">
								Pickup Location
							</div>
							<div class="panel-body">
								<div class = "row">
									<div class = "col-md-4">
										<div class = "col-md-12">
											{{ csrf_field() }}	
											<div class="form-group required">
												<label class = "control-label ">Location Name: </label>
												<div class="input-group">
													<select class = "form-control" id = "pickup_id">
														<option value = "0"></option>
														@forelse($locations as $location)
														<option value = "{{ $location->id }}">{{ $location->name }}</option>
														@empty
														@endforelse
													</select>
													<span class="input-group-btn">
														<button class="btn btn-primary pick_add_new_location" type="button">+</button>
													</span>
												</div>
											</div>
										</div>
										<div class = "col-md-12">
											
										</div>
									</div>
									<div class = "col-md-8">
										{{ csrf_field() }}
										<div class = "col-md-12">
											<div class = "col-md-12">
												<div class = "col-md-12">
													<div class="form-group required">
														<label class = "control-label">Address: </label>
														<textarea class = "form-control" disabled  id = "_address"></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class = "col-md-12">
											<div class = "col-md-4">
												<div class =  "col-md-12">
													<div class = "form-group">
														<label class = "control-label">City</label>
														<input type = "text" class = "form-control" disabled id = "_city" />
													</div>
												</div>
											</div>
											<div class = "col-md-4">
												<div class = "col-md-12">
													<div class = "form-group">
														<label class = "control-label">Province</label>
														<input type = "text" class = "form-control"  disabled id = "_province" />
													</div>
												</div>
											</div>
											<div class = "col-md-4">
												<div class = "col-md-12">
													<div class = "form-group">
														<label class = "control-label">ZIP</label>
														<input type = "text" class = "form-control" disabled id = "_zip" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	


							<div class = "panel-heading">
								Destination Location
							</div>
							<div class="panel-body">
								<div class = "row">
									<div class = "col-md-4">
										<div class = "col-md-12">
											{{ csrf_field() }}	
											<div class="form-group required">
												<label class = "control-label ">Location Name: </label>
												<div class="input-group">
													<select class = "form-control" id = "deliver_id">
														<option value = "0"></option>
														@forelse($locations as $location)
														<option value = "{{ $location->id }}">{{ $location->name }}</option>
														@empty
														@endforelse
													</select>
													<span class="input-group-btn">
														<button class="btn btn-primary del_add_new_location" type="button">+</button>
													</span>
												</div>
											</div>
										</div>
										<div class = "col-md-12">

										</div>
									</div>
									<div class = "col-md-8">
										{{ csrf_field() }}
										<div class = "col-md-12">
											<div class = "col-md-12">
												<div class = "col-md-12">
													<div class="form-group required">
														<label class = "control-label">Address: </label>
														<textarea class = "form-control" disabled  id = "_daddress"></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class = "col-md-12">
											<div class = "col-md-4">
												<div class =  "col-md-12">
													<div class = "form-group">
														<label class = "control-label">City</label>
														<input type = "text" class = "form-control" disabled id = "_dcity" />
													</div>
												</div>
											</div>
											<div class = "col-md-4">
												<div class = "col-md-12">
													<div class = "form-group">
														<label class = "control-label">Province</label>
														<input type = "text" class = "form-control"  disabled id = "_dprovince" />
													</div>
												</div>
											</div>
											<div class = "col-md-4">
												<div class = "col-md-12">
													<div class = "form-group">
														<label class = "control-label">ZIP</label>
														<input type = "text" class = "form-control" disabled id = "_dzip" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group required">
								<br/>
								<label class = "control-label col-md-3">Standard Rate: </label>
								<div class = "form-group input-group " >
									<span class = "input-group-addon">Php</span>
									<input type = "text"  class = "form-control money" name = "amount" id = "amount"  data-rule-required="true" value="0.00" />
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


<section class="content">
	<div class="modal fade" id="chModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New Location</h4>
				</div>
				<div class="modal-body">
					<form role="form" method = "POST" id="commentForm" class = "form-horizontal">
						{{ csrf_field() }}	
						<div class="form-group required">
							<label class = "control-label col-md-3">Name: </label>
							<div class = "col-md-9">
								<input type = "text" class = "form-control" name = "name" id = "name" minlength = "3"/>
							</div>
						</div>
						<div class="form-group required">
							<label class = "control-label col-md-3">Address: </label>
							<div class = "col-md-9">
								<textarea class = "form-control" id = "address" name = "address"></textarea>
							</div>
						</div>
						<div class="form-group required">
							<label class = "control-label col-md-3">Province: </label>
							<div class = "col-md-9">
								<select name = "loc_province" id="loc_province" class = "form-control">
									<option value = '0'></option>
									@forelse($provinces as $province)
									<option value="{{ $province->id }}" >
										{{ $province->name }}
									</option>
									@empty

									@endforelse
								</select>     
							</div>
						</div>
						<div class="form-group required">
							<label class = "control-label col-md-3">City: </label>
							<div class = "col-md-9">
								<select name = "loc_city" id="loc_city" class = "form-control">
									<option value="0"></option>
								</select>
							</div>
						</div>
						<div class="form-group required">
							<label class = "control-label col-md-3">ZIP: </label>
							<div class = "col-md-9">
								<input type = "text" class = "form-control" name = "zip" id = "zip" minlength = "3"/>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type = "submit" class="btn btn-success btnSave" >Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
				</div>
			</div>
		</div>
	</div>
</section>
</div>

@endsection
@push('styles')
<style>
	.class-area-rates
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

		function fill_cities(num)
		{
			console.log(num);
			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#loc_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){
						
						var new_rows = "<option value = '0'></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#loc_city').find('option').not(':first').remove();
						$('#loc_city').html(new_rows);
						
						$('#loc_city').val(num);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		}

		$(document).on('change', '#loc_province', function(e){
			fill_cities(0);
		})

		$(document).on('click', '.pick_add_new_location', function(e){
			e.preventDefault();
			$('.modal-title').text("New Location");
			$('#chModal').modal('show');
			selected_location = 0;
		})

		$(document).on('click', '.del_add_new_location', function(e){
			e.preventDefault();
			$('.modal-title').text("New Location");
			$('#chModal').modal('show');
			selected_location = 1;
		})




		$(document).on('change', '#pickup_id', function(e){
			pickup_id = $(this).val();
			if(pickup_id != 0)
			{
				$.ajax({
					type: 'GET',
					url: '{{ route("location.index") }}/' + pickup_id + '/getLocation',
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){

						if(typeof(data) == "object"){
							$('#_address').val(data[0].address);
							$('#_city').val(data[0].city_name);
							$('#_province').val(data[0].province_name);
							$('#_zip').val(data[0].zipCode);
						}
					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else{
				$('#_address').val("");
				$('#_city').val("");
				$('#_province').val("");
				$('#_zip').val("");
			}
			
		})

		$(document).on('change', '#deliver_id', function(e){
			deliver_id = $(this).val();
			if(deliver_id != 0)
			{
				$.ajax({
					type: 'GET',
					url: '{{ route("location.index") }}/' + deliver_id + '/getLocation',
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){

						if(typeof(data) == "object"){
							$('#_daddress').val(data[0].address);
							$('#_dcity').val(data[0].city_name);
							$('#_dprovince').val(data[0].province_name);
							$('#_dzip').val(data[0].zipCode);
						}
					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else{
				$('#_daddress').val("");
				$('#_dcity').val("");
				$('#_dprovince').val("");
				$('#_dzip').val("");
			}
			
		})

		$(document).on('click', '.btnSave', function(e){
			e.preventDefault();
			console.log('aw');
			$.ajax({
				type: 'POST',
				url: "{{ route('location.index')}}",
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('#name').val(),
					'address' : $('#address').val(),
					'cities_id' : $('#loc_city').val(),
					'zipCode' : $('#zip').val(),
				},
				success: function(data){
					if(selected_location == 0){	
						
						$('#_address').val($('#address').val());
						$('#_city').val($('#loc_city option:selected').text());
						$('#_province').val($('#loc_province option:selected').text().trim());
						$('#_zip').val($('#zip').val());
						$('#chModal').modal('hide');
					}
					else{
						$('#_daddress').val($('#address').val());
						$('#_dcity').val($('#loc_city option:selected').text());
						$('#_dprovince').val($('#loc_province option:selected').text().trim());
						$('#_dzip').val($('#zip').val());
						$('#chModal').modal('hide');

					}
					
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})


		$(document).on('click', '.finalize-sar', function(e){
			e.preventDefault();

			//if(finalvalidatesarRows() === true){
				
				var title = $('.modal-title').text();
				if(title === "New Standard Area Rate")
				{
					console.log("new new new");
					
					$.ajax({
						type: 'POST',
						url:  '/admin/sar_fee',
						data: {
							'_token' : $('input[name=_token]').val(),
							'areaFrom' : $('#pickup_id').val(),
							'areaTo' : $('#deliver_id').val(),
							'amount' : $('#amount').inputmask('unmaskedvalue'),
						},

						success: function (data){

							

							sartable.ajax.reload();
							$('#sarModal').modal('hide');
							$('.modal-title').text('New Standard Area Rate');
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
				}
			//}
		});






	});


		/*
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

	*/

	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush