@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp; Locations</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn but btn-md new"  style = "width: 100%;">New Location</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "ch_table">
					<thead>
						<tr>
							<td style="width: 20%;">
								Name
							</td>
							<td style="width: 30%;">
								Block No./Lot No./Street
							</td>
							<td style="width: 15%;">
								City
							</td>
							<td style="width: 15%;">
								Province
							</td>
							<td style="width: 5%;">
								Zip
							</td>
							<td style="width: 20%;">
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

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
								<label class = "control-label col-md-3">Block No./Lot No./Street: </label>
								<div class = "col-md-9">
									<textarea class = "form-control" id = "address" name = "address"></textarea>
								</div>
							</div>
							<div class="form-group required">
								<label class = "control-label col-md-3">Province: </label>
								<div class = "col-md-9">
									<select name = "loc_province" id="loc_province" class = "form-control">
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
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
	.location
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
	var location_id = null;
	var arr_provinces =[
	@forelse($provinces as $province)
	{ id: '{{ $province->id }}', text:'{{ $province->name }}' }, 
	@empty
	@endforelse
	];

	var data;

	$(document).ready(function(){
		var chtable = $('#ch_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: '{{ route("location_data") }}',
			columns: [
			
			{ data: 'location_name' },
			{ data: 'location_address' },
			{ data: 'city_name' },
			{ data: 'province_name' },
			{ data: 'zipCode' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$("#loc_city").select2({
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
		$("#loc_province").select2({
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

		Inputmask("9{4}").mask($("#zip"));

		$(document).on('click', '.new', function(e){
			e.preventDefault();
			$('.modal-title').text("New Location");
			$('#name').val("");
			$('#address').val("");
			$('#loc_province').val("0");
			$('#loc_city').val("0");
			$('#zip').val("");

			$('#chModal').modal("show");
		})
		$(document).on('click', '.btnSave', function(e){
			e.preventDefault();
			if($('.modal-title').text() == "New Location"){

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
						$('#chModal').modal('hide');
						chtable.ajax.reload();

					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else{
				$.ajax({
					type: 'PUT',
					url: "{{ route('location.index')}}/" + location_id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : $('#name').val(),
						'address' : $('#address').val(),
						'cities_id' : $('#loc_city').val(),
						'zipCode' : $('#zip').val(),
					},
					success: function(data){
						$('#chModal').modal('hide');
						chtable.ajax.reload();

					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})

			}
		})

		$(document).on('click', '.edit', function(e){
			e.preventDefault();
			location_id = $(this).closest('tr').find('.location_id').val();
			console.log(location_id);
			$('.modal-title').text("Update Location");
			var data = chtable.row($(this).parents()).data();
			$('#name').val(data.location_name);
			$('#address').val(data.location_address);
			$('#zip').val(data.zipCode);
			$('#loc_province').val($(this).closest('tr').find('.province_id').val());
			fill_cities($(this).closest('tr').find('.city_id').val());
			
			$('#chModal').modal('show');
		})

		$(document).on('click', '.deactivate', function(e){
			e.preventDefault();
			location_id = $(this).closest('tr').find('.location_id').val();
			$('#confirm-delete').modal('show');
		})

		$(document).on('click', '#btnDelete', function(e){
			e.preventDefault();
			$.ajax({
					type: 'DELETE',
					url: "{{ route('location.index')}}/" + location_id,
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){
						$('#confirm-delete').modal('hide');
						chtable.ajax.reload();

					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
		})

		$(document).on('change', '#loc_province', function(e){
			fill_cities(0);
		})

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
	})
</script>
@endpush