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
				<table class = "table-responsive table table-striped cell-border table-bordered" id = "lc_table">
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
<section class="content">
	
	<form role="form" method = "POST" id="commentForm">
		{{ csrf_field() }}
		<div class="modal fade" id="lcModal" role="dialog">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New City</h4>
					</div>
					<div class="modal-body ">		
						<div class="form-group required">
							<label class="control-label">Province:</label>
							<div class = "input-group " >
								<select name = "loc_province" id="loc_province" class = "form-control " >
									@forelse($provinces as $province)
									<option value="{{ $province->id }}">{{ $province->name }}</option>
									@empty
									@endforelse
								</select> 
								<span class="input-group-btn">
									<button class="btn btn-primary new_province" type="button">+</button>
								</span>
							</div>
						</div>
						<div class="form-group required">
							<label class = "control-label"><strong>City</strong></label>
							<input type = "text" class = "form-control  lc_city_valid"  placeholder="Enter a city" name = "city" id = "city" value=""  data-rule-required="true"/>
						</div>
						<br />
						<small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>
					</div>
					<div class="modal-footer">
						<button id = "btnSave" type = "submit" class="btn btn-success finalize-lc">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>			
					</div>
				</div>
			</div>
			
		</form>
	</div>
</section>
<section class="content">
	<form role="form" method = "POST" id="provinceForm">
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
	$('#deliverycollapse').addClass('in');
	$('#collapse2').addClass('in');
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
					lettersonly:true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},	
				}
			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});
		$("#provinceForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					lettersonly:true,
					minlength: 3,
					maxlength: 50,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},	
				}
			},
			onkeyup: function(element) {$(element).valid()}, 
			
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

			
			$('#city').val(data.city);
			$('#lcModal').modal('show');
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



		$(document).on('click', '.new_province', function(e){
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

					$('#mySelect').append($('<option selected>', {value: data.id,text: data.name
					}));
					console.log ("latest is "+$latest);


					if(typeof(data) === "object"){
						$('#lpModal').modal('hide');
						$('#name').val("");
						$('.modal-title').text('New Province');

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
					else{
						resetErrors();
						var invdata = JSON.parse(data);
						$.each(invdata, function(i, v) {
							console.log(i + " => " + v); 
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
				
				$.ajax({

					type: 'POST',
					url:  '/admin/location_city',
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#city').val(),
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