@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Exchange Rate</h2>
		<hr>
		<h5>Current Exchange Rate: Php</h5>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#erModal" style = "width: 100%;">New Exchange Rate</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table" id = "er_table">
					<thead>
						<tr>
							<td>
								No.
							</td>
							<td>
								Rate
							</td>
							<td>
								Remarks
							</td>
							<td>
								Date Effective
							</td>
							<td>
								Created at
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

	<section class="content">
		<form role="form" method = "POST" id="commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="erModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Exchange Rate</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group">
								<label>Current Rate: </label>
								<input type = "text" class = "form-control money" value = "P 0.00" style = "text-align: right" readonly = "true" />
							</div>
							<div class="form-group  required">
								<label class ="control-label">1 US Dollar equals</label>
								<div class = "form-group input-group " >
									<span class = "input-group-addon">Php</span>
									<input type = "text" class = "form-control money_er" name = "rate" id = "rate" data-rule-required="true" value= "0.0000000"/>
								</div>



							</div>
							<div class="form-group required">
								<label class = "control-label">Date Effective</label>
								<input type = "date" class = "form-control" name = "dateEffective" id="dateEffective" data-rule-required="true" />
							</div>
							<div class=" ">
								<label class = "form-group">Remarks</label>
								<textarea  row = "6" class = "form-control" id = "description" ></textarea> </div>
							</div>
							<input type="hidden" name = "currentRate" value = "0" />

							<div class="modal-footer">
								<input id = "btnSave" type = "submit" class="btn btn-success" value = "Save" />
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
		.class-exchange-rate{
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
		var data;
		$(document).ready(function(){
			var ertable = $('#er_table').DataTable({
				processing: true,
				serverSide: true,
				ajax: 'http://localhost:8000/admin/erData',
				columns: [
				{ data: 'id' },
				{ data: 'rate',
				"render" : function( data, type, full ) {
					return formatNumber(data); } },
					{ data: 'description' },
					{ data: 'dateEffective' },
					{ data: 'created_at'},
					{ data: 'action', orderable: false, searchable: false }

					],	"order": [[ 0, "desc" ]],
				});



			$("#commentForm").validate({
				rules: 
				{
					rate:
					{
						required: true,
					},
					dateEffective:
					{
						required: true,
					},


				},
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
        	return false;
        }
    });


			$(document).on('click', '.new', function(e){
				resetErrors();
				$('.modal-title').text('New Exchange Rate');
				$('#description').val("");
				$('rate').val("");
				$('dateEffective').val("");
				var now = new Date();

				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				$('#dateEffective').val(today);

				$('#erModal').modal('show');

			});
			$(document).on('click', '.edit',function(e){
				resetErrors();
				var ct_id = $(this).val();
				data = ertable.row($(this).parents()).data();
				$('#description').val(data.description);
				$('#rate').val(data.rate);
				$('#dateEffective').val(data.dateEffective);
				$('.modal-title').text('Edit Exchange Rate');
				$('#erModal').modal('show');
			});
			$(document).on('click', '.deactivate', function(e){
				var ct_id = $(this).val();
				data = ertable.row($(this).parents()).data();
				$('#confirm-delete').modal('show');
			});



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type: 'DELETE',
		url:  '/admin/exchange_rate/' + data.id,
		data: {
			'_token' : $('input[name=_token').val()
		},
		success: function (data)
		{
			ertable.ajax.reload();
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




// Confirm Save Button
$('#btnSave').on('click', function(e){

	var rate_nocomma = $('#rate').inputmask("unmaskedvalue");
	if (rate_nocomma == "0.00"){
		rate_nocomma = "";
	}

	e.preventDefault();
	var title = $('.modal-title').text();
	if(title == "New Exchange Rate")
	{
		$.ajax({
			type: 'POST',
			url:  '/admin/exchange_rate',
			data: {
				'_token' : $('input[name=_token]').val(),
				'rate' : rate_nocomma,
				'dateEffective' : $('input[name=dateEffective]').val(),
				'description' : $('input[name=description]').val(),
				'currentRate' : $('input[name=currentRate]').val(),
			},
			success: function (data)
			{
				



				if(typeof(data) === "object"){
					ertable.ajax.reload();
					$('#erModal').modal('hide');


					$('.modal-title').text('New Exchange Rate');
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
	}
	else
	{
		$.ajax({
			type: 'PUT',
			url:  '/admin/exchange_rate/' + data.id,
			data: {
				'_token' : $('input[name=_token]').val(),
				'description' : $('input[name=description]').val(),
				'rate' : rate_nocomma,
				'dateEffective' : $('input[name=dateEffective]').val(),
				'currentRate' : $('input[name=currentRate]').val(),
			},
			success: function (data)
			{
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

				ertable.ajax.reload();
				$('#erModal').modal('hide');
				$('#description').val("");
				$('rate').val("");
				$('dateEffective').val("");
				$('.modal-title').text('New Exchange Rate');
			}
		})
	}
});





});

function resetErrors() {
	$('form input, form select').removeClass('inputTxtError');
	$('label.error').remove();
}
</script>
@endpush