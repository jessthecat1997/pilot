@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h3> Maintenance |Brokerage|Tariff Book|Item</h3>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#itemModal" style = "width: 100%;">New Item</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table cell-border table-striped table-bordered" id = "item_table" style="width: 100%;">
					<thead>
						<tr>
							<td>
								Section
							</td>
							<td >
								Category Name
							</td>
							<td>
								Item
							</td>
							<td>
								HS Code:
							</td>
							<td>
								Rate
							</td>
							<td >
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($items as $i)
						<tr>
							<td>
								{{ $i->section }}
							</td>
							<td>
								{{ $i->category}}
							</td>
							<td>
								{{ $i->item }}
							</td>
							<td>
								{{ $i->hsCode }}
							</td>
							<td>
								{{ $i->rate }}
							</td>
							<td>
								<button value = "{{ $i->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $i->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
							</td>
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="itemModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Item</h4>
						</div>
						<div class="modal-body">	
							<div class = "form-group required" >
								<label class = "control-label">Section</label>
								<select class = "form-control" id = "sections_id" name="sections_id" >
									@forelse($sections as $section)
									<option value = "{{ $section->id }}">{{ $section->name }}</option>
									@empty
									@endforelse
								</select>

							</div>	
							<div class = "form-group required" >
								<label class = "control-label">Category</label>
								<select class = "form-control" id = "category_types_id" name="category_types_id" >
									@forelse($category as $cat)
									<option value = "{{ $cat->id }}">{{ $cat->name }}</option>
									@empty
									@endforelse
								</select>

							</div>		
							<div class="form-group required">
								<label class = "control-label">Item Name</label>
								<textarea rows = "3" type = "text" class = "form-control" name = "name" id = "name" required ></textarea> 
							</div>

							<div class="form-group">
								<label class = "control-label">HS Code</label>
								<input class = "form-control hsCode" name = "hsCode" id = "hsCode">
							</div>
							<div class = "form-group required">
								<label class = "control-label">Rate</label>
								<div class = " input-group " >
									<input type = "number" class = "form-control money" name = "rate" id = "rate"  data-rule-required="true" max="100" value="0" style="text-align: right" />
									<span class = "input-group-addon">%</span>
								</div>
							</div>

							
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
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
							Confirm Deactivate
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
	<div class="modal fade" id="confirm-activate" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Activate record
				</div>
				<div class="modal-body">
					Confirm Activating
				</div>
				<div class="modal-footer">
					<button class = "btn btn-success" id = "btnActivate" >Activate</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
.class-item{
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
	$('#collapse2').addClass('in');
	$('#brokeragecollapse').addClass('in');
	$('#tariffcollapse').addClass('in');
	var data;
	var temp_name = null;
	var temp_desc = null;
	var temp_section = null;
	var temp_rate = null;
	var temp_hsCode = null;
	var item_id;
	$(document).ready(function(){
		var itemtable = $('#item_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'section'},
			{ data: 'category' },
			{ data: 'item'},
			{ data: 'hsCode' },
			{ data: 'rate'},
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});



		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				itemtable.ajax.url( '{{ route("item.data") }}/1').load();
			}
			else{
				itemtable.ajax.url( '{{ route("item.data") }}').load();
			}
		})


		$(document).on('change', '#sections_id', function(e){
			fill_category(0);
		})


		var validator = $("#commentForm").validate({
			rules: 
			{
				name:
				{
					required: true,
					minlength: 3,
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
					NoSpecialCharacters:true,

				},

				hsCode:
				{
					normalizer: function(value) {
						value = value.replace("something", "new thing");
						return $.trim(value)
					},
				},
				sections_id:
				{
					required: true,
				},
				category_types_id:
				{
					required: true,
				},
				rate:
				{
					min: 0,
					max: 100,
					required: true,
				}


			},
			onkeyup: function(element) {$(element).valid()}, 

		});

		$('.hsCode').keyup(function(){
			var val = $(this).val();
			if(isNaN(val)){
				val = val.replace(/[^0-9\.^0-9.^0-9.^0-9.^0-9.^0-9]/g,'');
				if(val.split('.').length>5) 
					val =val.replace(/\.+$/,"");
			}
			$(this).val(val); 
		});


		$(document).on('click', '.activate', function(e){
			item_id = $(this).val();
			data = itemtable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/item_reactivate/' + item_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					itemtable.ajax.url( '{{ route("item.data") }}/1' ).load();
					$('#confirm-activate').modal('hide');

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
					toastr["success"]("Record activated successfully")
				}
			})
		});

		$(document).on('click', '.new', function(e){
			resetErrors();
			$('.modal-title').text('New Item');
			$('#name').val("");
			$('#hsCode').val("");
			$('#itemModal').modal('show');

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			item_id = $(this).val();
			data = itemtable.row($(this).parents()).data();
			$('#name').val(data.item);	
			$('#hsCode').val(data.hsCode);
			$('#rate').val(data.rate);
			$("#sections_id option:contains(" + data.section +")").attr("selected", true);
			$("#category_types_id option:contains(" + data.category +")").attr("selected", true);
			temp_name = data.item;
			temp_section = $('#sections_id').val();
			temp_hsCode = data.hsCode;
			temp_rate = data.rate;

			$('.modal-title').text('Update Item');
			$('#itemModal').modal('show');
		});
		$(document).on('click', '.deactivate', function(e){
			item_id = $(this).val();
			data = itemtable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/item/' + item_id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			itemtable.ajax.url( '{{ route("item.data") }}' ).load();
			$('#confirm-delete').modal('hide');

			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"rtl": false,
				"positionClass": "toast-bottom-right",
				"preventDupliitemes": false,
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
function fill_category(num)
{
	console.log(num);
	$.ajax({
		type: 'GET',
		url: "{{ route('get_item_categories')}}/" + $('#sections_id').val(),
		data: {
			'_token' : $('input[name=_token]').val(),
		},
		success: function(data){
			if(typeof(data) == "object"){

				var new_rows = "";
				for(var i = 0; i < data.length; i++){
					new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
				}
				$('#category_types_id').find('option').not(':first').remove();
				$('#category_types_id').html(new_rows);

				$('#category_types_id').val(num);
			}
		},
		error: function(data) {
			if(data.status == 400){
				alert("Nothing found");
			}
		}
	})
}


// Confirm Save Button
$('#btnSave').on('click', function(e){
	e.preventDefault();
	var title = $('.modal-title').text();

	if(title == "New Item")
	{
		if($('#name').valid() && $('#hsCode').valid()){
			

			$.ajax({
				type: 'POST',
				url:  '/admin/item',
				data: {
					'_token' : $('input[name=_token]').val(),
					'sections_id': $('#sections_id').val(),
					'category_types_id':  $('#category_types_id').val(),
					'name' : $('#name').val(),
					'hsCode':  $('#hsCode').val(),
					'rate':  $('#rate').val(),
				},
				success: function (data)
				{
					if(typeof(data) === "object"){
						itemtable.ajax.url( '{{ route("item.data") }}' ).load();
						$('#itemModal').modal('hide');
						$('#hsCode').val("");
						$('.modal-title').text('New Item');

					//Show success

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDupliitemes": false,
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
					toastr["success"]("Record added successfully");

					$('#name').val("");
					$('#hsCode').val("");
					$('#itemModal').modal('hide');
					$('#rate').val("0");

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
			},
			
		})
		}
	}
	else
	{
		if($('#name').valid() && $('#hsCode').valid()){
			if($('#name').val() === temp_name && $('#hsCode').val() === temp_hsCode && $('#rate').val() === temp_rate){
				$('#name').val("");
				$('#hsCode').val("");
				
				$('#itemModal').modal('hide');
			}
			else{
			

				$.ajax({
					type: 'PUT',
					url:  '/admin/item/' + item_id,
					data: {
						'_token' : $('input[name=_token]').val(),
						'sections_id': $('#sections_id').val(),
						'category_types_id':  $('#category_types_id').val(),
						'name' : $('#name').val(),
						'hsCode':  $('#hsCode').val(),
						'rate':  $('#rate').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							itemtable.ajax.url( '{{ route("item.data") }}' ).load();
							$('#itemModal').modal('hide');
							$('#hsCode').val("");
							$('#rate').val("0");
							$('.modal-title').text('New Item');

					//Show success

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDupliitemes": false,
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
					toastr["success"]("Record updated successfully");

					$('#name').val("");
					$('#hsCode').val("");
					$('#itemModal').modal('hide');
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
			},
			
		})
			}
		}
	}
	
});
});



function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush