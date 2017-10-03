@extends('layouts.utilities')

@section('content')

<h2>&nbsp;Utilities | Brokerage Setting</h2>
<hr>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				General Setting
			</div>
			<div class="panel-body">
				<form role="form" method = "POST" id = "commentForm">
					{{ csrf_field() }}
					@forelse($utility as $util)
					<div class = "form-group required">
						<label class = "control-label">Logo</label>
						 <center><img class="img-responsive" id="logo" src="/{{$util->company_logo}}" " /></center>
						
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
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Duties and Taxes Computation Setting
					</div>
					<div class="panel-body">
						{{ csrf_field() }}
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
						<div class = "form-group required">
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
					min:10,
					max: 15,
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

			},
			onkeyup: function(element) {$(element).valid()}, 
			
		});

		function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#util-pic')
                        .attr('src', e.target.result)
                        .width(180);
                    };
                reader.readAsDataURL(input.files[0]);
            }
        }

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
			
	/*		if( temp_bank_charges === $('#bank_charges').val() && temp_other_charges === $('#other_charges').val()
				&& temp_insurance_c === $('#insurance_c').val() && temp_insurance_gc === $('#insurance_gc').val()
				&& temp_company_name === $('#company_name').val() && temp_company_address === $('company_address').val() 
				&& temp_company_tin === $('#company_tin').val() && temp_company_contact === $('company_contact').val()

				)
			{

				alert("No fields modified.");



			}else{
*/
				$('#btnSave').attr('disabled', 'true');

				$.ajax({
					type: 'PUT',
					url:  '/utilities/brokerage/'+ 1,
					data: {
						'_token' : $('input[name=_token').val(),
						'other_charges' : $('#other_charges').val(),
						'bank_charges': $('#bank_charges').val(),
						'insurance_gc': $('#insurance_gc').val(),
						'insurance_c': $('#insurance_c').val(),

						'company_name': $('#company_name').val(),
						'company_address': $('#company_address').val(),
						'company_tin' : $('#company_tin').val(),
						'company_contact': $('#company_contact').val(),
					},
					success: function (data)
					{
						if(typeof(data) === "object"){
							$('#other_charges').val(data.other_charges);
							$('#bank_charges').val(data.bank_charges);
							$('#insurance_c').val(data.insurance_c);
							$('#insurance_gc').val(data.insurance_gc);
							$('#company_name').val(data.company_name);
							$('#company_address').val(data.company_address);
							$('#company_tin').val(data.company_tin);
							$('#company_contact').val(data.company_contact);
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


					},
				})
//			}
		});

	});
</script>


@endpush
