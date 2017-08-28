@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance |Delivery | Standard Area Rates</h3>
			<hr>
			<div class = "col-md-3 col-md-offset-9">
				<button  class="btn btn-info btn-md new" style = "width: 100%;">New Standard Area Rates</button>
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
									Location From
								</td>
								<td>
									Location To
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
		{{ csrf_field() }}
		<div class="modal fade" id="sarModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="sarModal-title">New Standard Area Rate</h4>
						</div>
						<div class="modal-body">
							<div class = "col-md-6">		
								
								<h4>Pickup Location</h4>
								
								<div >
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
									{{ csrf_field() }}
									<div class="form-group required">
										<label class = "control-label">Block No./Lot No./Street</label>
										<textarea class = "form-control" disabled  id = "_address"></textarea>
									</div>
									<div class = "form-group">
										<label class = "control-label">City</label>
										<input type = "text" class = "form-control" disabled id = "_city" />
									</div>
									<div class = "form-group">
										<label class = "control-label">Province</label>
										<input type = "text" class = "form-control"  disabled id = "_province" />
									</div>
									<div class = "form-group">
										<label class = "control-label">ZIP</label>
										<input type = "text" class = "form-control" disabled id = "_zip" />
									</div>
								</div>
							</div>
							<div class ="col-md-6">

								
								<h4>Destination Location</h4>

								<div >
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

									{{ csrf_field() }}

									<div class="form-group required">
										<label class = "control-label">Block No./Lot No./Street</label>
										<textarea class = "form-control" disabled  id = "_daddress"></textarea>
									</div>

									<div class = "form-group">
										<label class = "control-label">City</label>
										<input type = "text" class = "form-control" disabled id = "_dcity" />
									</div>

									<div class = "form-group">
										<label class = "control-label">Province</label>
										<input type = "text" class = "form-control"  disabled id = "_dprovince" />
									</div>

									<div class = "form-group">
										<label class = "control-label">ZIP</label>
										<input type = "text" class = "form-control" disabled id = "_dzip" />

									</div>
								</div>
							</div>
							<div class="form-group required col-md-12">
								<br/>
								<label class = "control-label">Standard Rate: </label>
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
	$('#deliverycollapse').addClass('in');
	$('#collapse2').addClass('in');
	var temp_deliver_id = null;
	var temp_pickup_id = null;
	var temp_amount = null;
	var data;
	$(document).ready(function(){
		var sar_row = "<tr>" + $('#sar-row').html() + "</tr>";

		var sartable = $('#sar_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			'scrollx': true,
			ajax: 'http://localhost:8000/admin/sarData',
			columns: [

			{ data: 'areaFrom'},
			{ data: 'areaTo'},
			{ data: 'amount',
			"render" : function( data, type, full ) {
				return formatNumber(data); } },      

				{ data: 'action', orderable: false, searchable: false }

				],	"order": [[ 0, "desc" ]],


			});

		$(document).on('click', '.new', function(e){
			e.preventDefault();
			$('#sarModal').modal('show');
			$('#amount').val("0.00");
			$('#_address').val("");
			$('#_city').val("");
			$('#_province').val("");
			$('#_zip').val("");

			$('#_daddress').val("");
			$('#_dcity').val("");
			$('#_dprovince').val("");
			$('#_dzip').val("");
			$('#pickup_id').val("0");
			$('#deliver_id').val("0");

		})

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
			temp_pickup_id = $(this).val();
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
			temp_deliver_id = $(this).val();
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
						temp_deliver_id  = data.id;
						$('#_address').val($('#address').val());
						$('#_city').val($('#loc_city option:selected').text());
						$('#_province').val($('#loc_province option:selected').text().trim());
						$('#_zip').val($('#zip').val());
						$('#chModal').modal('hide');
					}
					else{
						temp_pickup_id = data.id;
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



		$(document).on('click', '.edit',function(e){
			resetErrors();
			var sar_id = $(this).val();
			data = sartable.row($(this).parents()).data();

			$('#pickup_id').val($(this).closest('tr').find('.pickup_id').val());
			$('#deliver_id').val($(this).closest('tr').find('.deliver_id').val());
			
			$('#amount').val(data.amount);

			var pickup_id = $('#pickup_id').val();

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

			deliver_id = $('#deliver_id').val();
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


			$('.sarModal-title').text('Update Standard Area Rate');
			$('#sarModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			var sar_id = $(this).val();
			data = sartable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});


		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/standard_arearates/' + data.id,
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

			$('#amount').valid();
			var title = $('.sarModal-title').text();
			console.log("hihiho" + title);
			if(title == "New Standard Area Rate")
			{
				console.log("new new new");

				$.ajax({
					type: 'POST',
					url:  '/admin/standard_arearates',
					data: {
						'_token' : $('input[name=_token]').val(),
						'areaFrom' : temp_pickup_id,
						'areaTo' : temp_deliver_id,
						'amount' : $('#amount').inputmask('unmaskedvalue'),
					},

					success: function (data){

						sartable.ajax.reload();
						$('#sarModal').modal('hide');
						$('.modal-title').text('New Standard Area Rate');
						$('#amount').val("0.00");
						$('#_address').val("");
						$('#_city').val("");
						$('#_province').val("");
						$('#_zip').val("");

						$('#_daddress').val("");
						$('#_dcity').val("");
						$('#_dprovince').val("");
						$('#_dzip').val("");

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
			else
			{
				if($('#pickup_id').valid() && $('#deliver_id').valid() && $('#amount').valid() )
				{

					if($('#pickup_id').val() === temp_pickup_id &&
						$('#deliver_id').val() === temp_deliver_id && 
						$('#amount').inputmask("unmaskedvalue") === temp_amount  )
					{
						$('#amount').val("0.00");
						$('#btnSave').removeAttr('disabled');
						$('#sarModal').modal('hide');
					}
					else
					{
						$('#btnSave').attr('disabled', 'true');

						$.ajax({
							type: 'PUT',
							url:  '/admin/standard_arearates/' + data.id,
							data: {
								'_token' : $('input[name=_token]').val(),'areaFrom' : $('#pickup_id').val(),
								'areaTo' : $('#deliver_id').val(),
								'amount' : $('#amount').inputmask('unmaskedvalue'),
							},

							success: function (data){

								if(typeof(data) === "object"){
									sartable.ajax.reload();
									$('#sarModal').modal('hide');
									$('.modal-title').text('New Standard Area Rate');
									$('#amount').val("0.00");
									$('#_address').val("");
									$('#_city').val("");
									$('#_province').val("");
									$('#_zip').val("");

									$('#_daddress').val("");
									$('#_dcity').val("");
									$('#_dprovince').val("");
									$('#_dzip').val("");

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
								else{
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


		function resetErrors() {
			$('form input, form select').removeClass('inputTxtError');
			$('label.error').remove();
		}
	})
</script>
@endpush