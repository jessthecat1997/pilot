@extends('layouts.utilities')

@section('content')

<h2>&nbsp;Utilities | Brokerage Setting</h2>
<hr>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Duties and Taxes Computation Setting
			</div>
			<div class="panel-body">
				<form role="form" method = "POST" id = "commentForm">
					{{ csrf_field() }}
					@forelse($brokerage_utility as $bu)
					<div class = "form-group required">
						<label class = "control-label">Bank Charges</label>
						<div class = " input-group " >
							<input type = "number" class = "form-control percentage" name = "bank_charges" id = "bank_charges"  data-rule-required="true" max="100" value="{{$bu->bank_charges}}" style="text-align: right" />
							<span class = "input-group-addon">%</span>
						</div>
					</div>
					<div class = "form-group required">
						<label class = "control-label">Other Charges</label>
						<div class = " input-group " >
							<input type = "number" class = "form-control percentage" name = "other_charges" id = "other_charges"  data-rule-required="true" max="100" value="{{$bu->other_charges}}" style="text-align: right" />
							<span class = "input-group-addon">%</span>
						</div>
					</div>
					@empty
					@endforelse
				</form>
			</div>
			<div class="panel-footer ">
				<div style="padding-left: 70%" > 
					<input id = "btnSave" type = "submit" class="btn btn-success submit " value = "Save" />&nbsp;&nbsp;
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>	
				</div>			
			</div>
		</div>
	</div>
	
</div>
@endsection
@push('styles')
<style>
.class-brokerage-utilities
{
	border-left: 10px solid #8ddfcc;
	background-color:rgba(128,128,128,0.1);
	color: #fff;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript">

	@forelse($brokerage_utility as $bu)
	var temp_other_charges = {{$bu->other_charges}};
	var temp_bank_charges = {{$bu->bank_charges}};
	@empty
	@endforelse

	$(document).ready(function(){


		$("#commentForm").validate({
			rules: 
			{
				
				other_charges:
				{
					required: true,
					max: 100,
					min: 0,
				},
				bank_charges:
				{
					required:true,
					max:100,
					min:0,
				}
			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});


		$(document).on('keyup keydown keypress', '.percentage', function (event) {
			var len = $('.percentage').val();
			var value = $('.percentage').inputmask('unmaskedvalue');
			if (event.keyCode == 8) {
				if(parseFloat(value) == 0 || value == ""){
					$('.percentage').val("0.00");
				}
			}
			else
			{
				if(value == ""){
					$('.percentage').val("0.00");
				}
				if(parseFloat(value) <= 100.000000){
					
				}
				else{
					if(event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 116){

					}
					else{
						return false;
					}
				}
			}
			if(event.keyCode == 189)
			{
				return false;
			}			
		});




		$(document).on('click', '#btnSave', function(e){
			e.preventDefault();
			if( temp_bank_charges === $('#bank_charges').val() && temp_other_charges === $('#other_charges').val()){
				

			}else{
				$('#btnSave').attr('disabled', 'true');

				$.ajax({
					type: 'PUT',
					url:  '/utilities/brokerage/'+ 1,
					data: {
						'_token' : $('input[name=_token').val(),
						'other_charges' : $('#other_charges').val(),
						'bank_charges': $('#bank_charges').val()
					},
					success: function (data)
					{
						$('#other_charges').val(data.other_charges);
						$('#bank_charges').val(data.bank_charges);
						temp_other_charges = data.other_charges;
						temp_bank_charges = data.bank_charges;
						$('#btnSave').removeAttr('disabled');

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
						toastr["success"]("Successfully updated settings")

					},
				})
			}
		});

	});
</script>


@endpush
