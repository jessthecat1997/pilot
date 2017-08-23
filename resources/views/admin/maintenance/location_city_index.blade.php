@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3><img src="/images/bar.png"> Maintenance | Delivery | City</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#lcModal" style = "width: 100%;">New City</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "lc_table">
					<thead>
						<tr>
							<td>
								Province
							</td>
							<td>
								City
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
		<div class="modal fade" id="lcModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New City</h4>
						</div>
						<div class="modal-body ">		
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Province:</label>
								<select name = "loc_province" id="loc_province" class = "form-control required select2_province">
								</select>     
							</div>

							<div class = "form-group">
								<button  id = "new_province" class = "btn btn-md btn-info new_province pull-right" data-toggle = 'modal' data-target = "#lpModal"  >New Province </button>
								<br>
							</div>		
						</form>
						<br />
						<div class = "collapse" id = "lc_table_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one city.
							</div>
						</div>
						<div class = "collapse" id = "lc_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the cities.
							</div>
						</div>
						<div class = "panel panel-default">
							<div  style="overflow-x: auto;">
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "lc_form" class = "commentForm">
										<table class="table responsive table-hover" width="100%" id= "lc_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
											<thead>
												<tr>
													<td >
														<div class="form-group required">
															<label class = "control-label"><strong>City</strong></label>
														</div>
													</td>
													<td  style="text-align: center;">
														<strong>Action</strong>
													</td>
												</tr>
											</thead>
											<tr id = "lc-row">
												<td width="90%">

													<div class = "form-group " >
														
														<input type = "text" class = "form-control  lc_city_valid"  placeholder="Enter a city" 
														name = "city" id = "city" value=""  data-rule-required="true"   />
													</div>

												</td>
												
												<td style="text-align: center;">
													<button class = "btn btn-danger btn-md delete-lc-row">x</button>
												</td>
											</tr>
										</table>
										<div class = "form-group" style = "margin-left:10px">
											<button    class = "btn btn-primary btn-md new-lc-row pull-left">New City</button>
											<br /><br />
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button id = "btnSave" type = "submit" class="btn btn-success finalize-lc">Save</button>
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
	<form role="form" method = "POST" id = "commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="lcModal_update" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update City</h4>
					</div>
					<div class="modal-body">
						<div class="form-group required">
							<label class="control-label " for="province">Province:</label>
							<select name = "loc_province_update" id="loc_province_update" class = "form-control required select2_province">
							</select>     
						</div>
						<div class = "form-group">
							<button  id = "new_province" class = "btn btn-md btn-info new_province pull-right" data-toggle = 'modal' data-target = "#lpModal"  >New Province </button>
							<br>
						</div>			
						<div class="form-group required">
							<label class = "control-label">Name:</label>
							<input type = "text" class = "form-control" name = "city_update" id = "city_update"  minlength = "2" data-rule-required="true" />

						</div>
					</div>
					<div class="modal-footer">
						<input id = "btnSave_update" type = "submit" class="btn btn-success submit" value = "Save" />
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<section class="content">
	<form role="form" method = "POST" id = "commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="lpModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Province</h4>
					</div>
					<div class="modal-body">			
						<div class="form-group required">
							<label class = "control-label">Name:</label>
							<input type = "text" class = "form-control" name = "name" id = "name"  minlength = "2" data-rule-required="true" />

						</div>
					</div>
					<div class="modal-footer">
						<input id = "btnSave_province" type = "submit" class="btn btn-success submit" value = "Save" />
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>				
					</div>
				</div>
			</div>
		</div>
	</form>
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
	.class-city
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
	var city_id = [];
	var city_id_descrp = [];
	var arr_provinces =[
	@forelse($provinces as $province)
	{ id: '{{ $province->id }}', text:'{{ $province->name }}' }, 
	@empty
	@endforelse
	];
	


	$(document).ready(function(){
		var lc_row = "<tr>" + $('#lc-row').html() + "</tr>";
		$('#collapse1').addClass('in');
		//$(city).attr("disabled", true);
		var lctable = $('#lc_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			'scrollx': true,
			ajax: 'http://localhost:8000/admin/lcData',
			columns: [

			{ data: 'province' },
			{ data: 'city'},


			
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],


		});





		$("#commentForm").validate({
			rules: 
			{
				loc_province:
				{
					required: true,
					
				},
				city:
				{
					required: true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					regex: /^[A-Za-z ]+$/,

				}

				
			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});

		$(".select2_province").select2({
			data: arr_provinces,
			width: '100%',
			sorter: function(data) {
				return data.sort(function (a, b) {
					if (a.text > b.text) {
						return 1;
					}
					if (a.text < b.text) {
						return -1;
					}
					return 0;
				});
			},
		});


		$(document).on('click', '.new', function(e){
			resetErrors();
			$('#lcModal').modal('show');

		});

		$(document).on('click', '.edit',function(e){
			resetErrors();
			e.preventDefault();
			var lc_id = $(this).val();
			data = lctable.row($(this).parents()).data();

			console.log("this is  " + data.province);

			$("#loc_province_update").select2("val", $("#loc_province_update option:contains('"+data.province+"')").val() );

			$('#city_update').val(data.city);
			$('#lcModal_update').modal('show');
		});

		$(document).on('click', '.deactivate', function(e){
			var lc_id = $(this).val();
			data = lctable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$(document).on('click', '.delete-lc-row', function(e){
			e.preventDefault();
			$('#lc_warning').removeClass('in');
			if($('#lc_parent_table > tbody > tr').length == 1){
				$('#lc_table_warning').addClass('fade in');
			}
			else{
				$(this).closest('tr').remove();
			}
		})

		$(document).on('click', '.new-lc-row', function(e){
			e.preventDefault();
			$('#lc_table_warning').removeClass('fade in');
			if(validatelcRows() === true){

				$('#lc_parent_table').append(lc_row);

				
			}
			

		})

		$(document).on('change', '.lc_city_valid', function(e){
			$(".lc_city_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');

				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})

		$(document).on('change', '.lc_city_valid', function(e){
			$(".lc_city_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');


				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})



		$(document).on('click', '#new_province', function(e){
			resetErrors();
			e.preventDefault();
			$('#name').val("");
			$('#lpModal').modal('show');

		});

		$('#btnSave_province').on('click', function(e){
			e.preventDefault();

			$.ajax({
				type: 'POST',
				url:  '/admin/location_province',
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('input[name=name]').val(),
				},
				success: function (data)
				{

					var lpdata = $('.select2_province').select2('data');
					arr_provinces.push({id:data.id,text:data.name});
					$latest = data.name;
					$(".select2_province").select2({
						data: arr_provinces,
						width: '100%',
					});

					console.log ("latest is "+$latest);

					$(".select2_province").select2("val", $(".select2_province option:contains('antipolo')").val() );

					if(typeof(data) === "object"){
						$('#lpModal').modal('hide');
						$('#name').val("");
						$('.modal-title').text('New Province');

					//Show success

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
				else{
					resetErrors();
					var invdata = JSON.parse(data);
					$.each(invdata, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
	        var msg = '<label class="error" for="'+i+'">'+v+'</label>';
	        $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
	    });
					
				}
			},
			
		})
		});




		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/location_city/' + data.id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					lctable.ajax.reload();
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

		$(document).on('click', '.finalize-lc', function(e){
			e.preventDefault();

			if(finalvalidatelcRows() === true){

				console.log('cities: ' + city_id);
				console.log('provinces_id: ' +  $('#loc_province').val());	
				$.ajax({

					type: 'POST',
					url:  '/admin/location_city',
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : city_id,
						'provinces_id' : $('#loc_province').val(),

					},

					success: function (data){



						lctable.ajax.reload();
						$('#lcModal').modal('hide');
						$('.modal-title').text('New City');
						$('#city').val("");

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
		});


		$(document).on('click', '#btnSave_update', function(e){
			console.log('update city: ' +$('input[name=city_update').val());
			console.log('update provinces_id: ' +  $('#loc_province').val());	
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/admin/location_city/' + data.id,
				data: {
					'_token' : $('input[name=_token]').val(),
					'name' : $('input[name=city_update').val(),
					'provinces_id' : $('#loc_province').val(),

				},
				success: function (data){



					lctable.ajax.reload();
					$('#lcModal_update').modal('hide');
					$('#city').val("");

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
					toastr["success"]("Record Updated successfully")

				}
			})


		});




	});






function validatelcRows()
{

	city_id = [];
	city_id_descrp = [];


	range_pairs = [];
	
	city =  document.getElementsByName('city');
	
	error = "";

	

	for(var i = 0; i < city.length; i++){
		var temp;




		if(city[i].value === "")
		{
			city[i].style.borderColor = 'red';
			error += "City Required.";
		}

		else
		{
			city[i].style.borderColor = 'green';
			city_id_descrp.push(city[i].value);
			city_id.push(city[i].value);
		}

		
		pair = {
			city: city[i].value,
		};
		range_pairs.push(pair);
	}
	var i, j, n;
	found= false;
	n=range_pairs.length;

	for (i=0; i<n; i++) {                        
		for (j=i+1; j<n; j++)
		{              
			if (range_pairs[i].city === range_pairs[j].city){
				found = true;
				
				city[j].style.borderColor = 'red';
				
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

	function finalvalidatelcRows()
	{
		city_id = [];
		city_id_descrp = [];
		
		range_pairs = [];

		city = document.getElementsByName('city');
		
		error = "";
		console.log("select is " + $('#loc_province').val());
		if($('#loc_province').val() == ""){

			document.getElementById("loc_province").style.borderColor = "red";
			error += "Province is required.";

		}else{
			document.getElementById("loc_province").style.borderColor = "green";

		}

		for(var i = 0; i < city.length; i++){


			if(city[i].value === "")
			{

				error += "city is Required.";
				$('#lc_warning').addClass('in');
			}

			else
			{

				city_id_descrp.push(city[i].value);
				var min = city[i].value
				city_id.push(city[i].value);
			}
			
			pair = {
				city: city[i].value,
				
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		found= false;
		n=range_pairs.length;
		for (i=0; i<n; i++) {                        
			for (j=i+1; j<n; j++)
			{              
				if (range_pairs[i].city === range_pairs[j].city ){
					found = true;
					
					city[i].style.borderColor = 'red';


					city[j].style.borderColor = 'red';
				}
			}	
		}
		if(found == true){
			error+= "Existing city.";
			$('#lc_warning').addClass('in');
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