@extends('layouts.utilities')

@section('content')

<h2>&nbsp;Utilities | Settings</h2>
<hr>
<form id = "commentForm" enctype="multipart/form-data" action = "{{ route('settings.index') }}/1" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="_method" value="PUT">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					General Setting
				</div>
				<div class="panel-body">
					@forelse($utility as $util)
					<div class = "form-group required">
						<label class = "control-label">Logo</label>
						<center><img class="img-responsive img-circle" id="company_logo" src="{{ $util->company_logo }}" style = "width: 300px; height: 200px"/></center>
						<br/>
						<br />
						<input type="file" name="logo" id = "logo" class="form-control" style="width: 100%;">
						
					</div>
					<div class = "form-group required">
						<label class = "control-label">Company Name:</label>
						
						<input type = "text" class = "form-control" name = "company_name" id = "company_name"  data-rule-required="true" value="{{$util->company_name}}" style="text-align: right" />
					</div>
					<div class = "form-group required">
						<label class = "control-label">Company Address:</label>
						
						<textarea class = "form-control" name = "company_address" id = "company_address"  data-rule-required="true" rows="5">{{$util->company_address}}</textarea>  
					</div>
					<div class = "form-group required">
						<label class = "control-label">Company TIN:</label>
						
						<input type = "text" class = "form-control" name = "company_tin" id = "company_tin"  data-rule-required="true" value="{{$util->company_tin}}" style="text-align: right" />
					</div>
					<div class = "form-group required">
						<label class = "control-label">Company Contact:</label>
						
						<input type = "text" class = "form-control" name = "company_contact" id = "company_contact"  data-rule-required="true" value="{{$util->company_contact}}" style="text-align: right" />
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Duties and Taxes Computation Setting
				</div>
				<div class="panel-body">
					<div class = "form-group required">
						<label class = "control-label">Bank Charges</label>
						<div class = " input-group " >
							<input type = "number" class = "form-control percentage" name = "bank_charges" id = "bank_charges"  data-rule-required="true" max="100" value="{{$util->bank_charges}}" style="text-align: right" />
							<span class = "input-group-addon">%</span>
						</div>
					</div>
					<div class = "form-group required">
						<label class = "control-label">Other Charges</label>
						<div class = " input-group " >
							<input type = "number" class = "form-control percentage" name = "other_charges" id = "other_charges"  data-rule-required="true" max="100" value="{{$util->other_charges}}" style="text-align: right" />
							<span class = "input-group-addon">%</span>
						</div>
					</div>
					<div class = "form-group ">
						<label class = "control-label">Insurance:</label>
						<div class = "form-group required" style="padding-left: 5%" >
							<label class = "control-label">General Cargo</label>
							<div class = " input-group " >
								<input type = "number" class = "form-control percentage" name = "insurance_gc" id = "insurance_gc"  data-rule-required="true" max="100" value="{{$util->insurance_gc}}" style="text-align: right" />
								<span class = "input-group-addon">%</span>
							</div>
						</div>
						<div class = "form-group required" style="padding-left: 5%" >
							<label class = "control-label">Dangerous Cargo</label>
							<div class = " input-group " >
								<input type = "number" class = "form-control percentage" name = "insurance_c" id = "insurance_c"  data-rule-required="true" max="100" value="{{$util->insurance_c}}" style="text-align: right" />
								<span class = "input-group-addon">%</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Billing Setting
				</div>
				<div class="panel-body">
					<div class = "form-group required">
						<label class = "control-label">Payment Allowance</label>
						<div class = " form-group input-group " >
							<input type = "number" class = "form-control money" name = "payment_allowance" id = "payment_allowance"  data-rule-required="true" max="365" value="{{$util->payment_allowance}}" style="text-align: right" />
							<span class = "input-group-addon">days</span>
						</div>
					</div>
					@empty
					@endforelse

					<div class = "form-group required">
						<label class = "control-label">Vat Rate</label>
						<div class = " form-group input-group " >
							@forelse($vat as $v)
							<input type = "number" class = "form-control percentage" name = "vat_rate" 
							id = "vat_rate"  data-rule-required="true"  value="{{$v->rate}}" style="text-align: right" />
							<span class = "input-group-addon">%</span>
							@empty
							@endforelse
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer ">
		<div style="padding-left: 70%" > 
			<input id = "btnSave" type = "submit" class="btn btn-success submit " value = "Save" />&nbsp;&nbsp;
		</div>			
	</div>
</form>
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
<script src="/js/jquery.form.js"></script>
<script type="text/javascript">

	/*@forelse($utility as $util)
	var temp_company_name = {{$util->company_name}};
	var temp_company_address = {{$util->company_address}};
	var temp_company_tin = {{$util->company_tin}};
	var temp_company_contact = {{$util->company_contact}};
	var temp_other_charges = {{$util->other_charges}};
	var temp_bank_charges = {{$util->bank_charges}};
	var temp_insurance_gc = {{$util->insurance_gc}};
	var temp_insurance_c = {{ $util->insurance_c }};
	
	@empty
	@endforelse
	*/
	$(document).ready(function(){

		var data;
		$("#commentForm").validate({
			rules: 
			{
				company_name:{
					required:true,
				},
				company_address:{
					required:true,
				},
				company_tin:{
					required:true,
				},
				company_contact:
				{
					required:true,
				},
				other_charges:
				{
					required: true,
					max: 100,
					min: 0,
					sevendecimalplaces:true,
				},
				bank_charges:
				{
					required:true,
					max:100,
					min:0,
					sevendecimalplaces:true,
				},
				insurance_gc:
				{
					required: true,
					max: 100,
					min: 0,
					sevendecimalplaces:true,
				},
				insurance_c:
				{
					required: true,
					max: 100,
					min: 0,
					sevendecimalplaces:true,
				},
				payment_allowance:
				{
					required: true,
					min: 1,
					max: 365,
				},
				vat_rate:
				{
					required: true,
					max: 100,
					min: 0,
					sevendecimalplaces:true,
				},


			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#company_logo').attr('src', e.target.result);
				}

				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#logo").change(function(){
			readURL(this);
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

		$("body").on("click",".submit",function(e){
			$(this).parents("form").ajaxForm(options);
		});

		var options = { 
			success: function(data)
			{
				if(typeof(data) === "object"){ 
					window.location.reload(); 
					$('#other_charges').val(data.other_charges); 
					$('#bank_charges').val(data.bank_charges); 
					$('#insurance_c').val(data.insurance_c); 
					$('#insurance_gc').val(data.insurance_gc); 
					$('#company_name').val(data.company_name); 
					$('#company_address').val(data.company_address); 
					$('#company_tin').val(data.company_tin); 
					$('#company_contact').val(data.company_contact); 
					$('#payment_allowance').val(data.payment_allowance); 
					$('#vat_rate').val(data.rate); 
					temp_other_charges = data.other_charges; 
					temp_bank_charges = data.bank_charges; 
					temp_insurance_gc = data.insurance_gc; 
					temp_insurance_c = data.insurance_c; 

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

				}else{ 

					resetErrors(); 
					var invdata = JSON.parse(data); 
					$.each(invdata, function(i, v) { 
						console.log(i + " => " + v);  
						var msg = '<label class="error" for="'+i+'">'+v+'</label>'; 
						$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg); 
					}); 
				}	
			}
		};

	});
	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>


@endpush
