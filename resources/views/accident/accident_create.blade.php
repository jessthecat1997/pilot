@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>&nbsp;New Accident</h2>
		</div>
		<div class="panel-body">
			<form>
				{{ csrf_field() }}
				<div class="col-md-5">
					<div class="row">
						<div class="form-group required">
							<label class="control-label">Incident Date</label>
							<input type="text" class = "form-control" name="incident_date" id = "incident_date">
						</div>
						<div class="form-group required">
							<label class="control-label">Time</label>
							<input type="text" class = "form-control" name="incident_time" id = "incident_time">
						</div>
						<div class="form-group required">
							<label class="control-label">Date Opened</label>
							<input type="text" class = "form-control" name="date_opened" id = "date_opened">
						</div>
						<div class="form-group">
							<label class="control-label">Date Closed</label>
							<input type="text" class = "form-control" name="date_closed" id = "date_closed">
						</div>
						<div class="form-group">
							<label class="control-label">Address</label>
							<textarea class="form-control" name="address" id="address"></textarea>
						</div>
						<div class="form-group">
							<label class="control-label">Province</label>
							<select class = "form-control" id = "loc_province">
								<option value="0"></option>
								@forelse($provinces as $province)
								<option value = "{{ $province->id }}">{{ $province->name }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">City</label>
							<select class = "form-control" id = "cities_id">
								
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Delivery</label>
							<select class = "form-control" id = "delivery_id" name="delivery_id">
								<option></option>
								@forelse($deliveries as $delivery)
								<option value="{{ $delivery->id }}">{{ $delivery->plateNumber }} - {{ Carbon\Carbon::parse($delivery->deliveryDateTime)->toFormattedDateString() }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group required">
							<label class="control-label">No. of Injuries</label>
							<input type="number" class = "form-control" name = "numberOfInjuries" id = "numberOfInjuries" value="0">
						</div>
						<div class="form-group required">
							<label class="control-label">No. of Fatalities</label>
							<input type="number" class = "form-control" name = "numberOfFatalities" id = "numberOfFatalities"  value="0">
						</div>
						<div class="form-group required">
							<label class="control-label">Property Damage</label>
							<div class="input-group">
								<span class="input-group-addon">Php</span>
								<input type="text" class="form-control money"  id = "propertyDamage" name = "propertyDamage" data-rule-required="true" style = "text-align: right" value = "0.00" required >
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label">Description</label>
							<textarea class = "form-control" name="description" id = "description"></textarea>
						</div>
						<div class="form-group">
							<button type = "save" class="btn but btn-md save-incident" style="width: 100%;">Save</button>
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="/js/jqueryDateTimePicker/jquery.datetimepicker.css">
@endpush
@push('scripts')
<script type="text/javascript" src = "/js/jqueryDateTimePicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click','.save-incident', function(e){
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url:  '{{ route("employees.index") }}/{{ $employee->id }}/accidents',
				data: {
					'_token' : $('input[name=_token').val(),
					'incident_date' : $('#incident_date').val(),
					'incident_time' : $('#incident_time').val(),
					'date_opened' : $('#date_opened').val(),
					'date_closed' : ($('#date_closed') === '____/__/__') ? $('#date_closed').val() : null,
					'address' : $('#address').val(),
					'cities_id' : $('#cities_id').val(),
					'delivery_id' : $('#delivery_id').val(),
					'numberOfInjuries' : $('#numberOfInjuries').val(),
					'numberOfFatalities' : $('#numberOfFatalities').val(),
					'propertyDamage' : $('#propertyDamage').inputmask('unmaskedvalue'),
					'description' : $('#description').val(),
					'employees_id' : {{ $employee->id }},
				},
				success: function (data)
				{
					console.log(data);
				}
			})
		})

		$(document).on('keyup keydown keypress', '.money', function (event) {
			var value = $('.money').inputmask('unmaskedvalue');
			if (event.keyCode == 8) {
				if(parseFloat(value) == 0 || value == ""){
					$('.money').val("0.00");
				}
			}
			else
			{
				if(value == ""){
					$('.money').val("0.00");
				}
				if(parseFloat(value) <= 9999999999999999.99){
					
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


		$.datetimepicker.setLocale('en');
		$('#incident_date').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			timepicker: false,
			lang:'en',
			format:'Y/m/d',
			formatDate:'Y/m/d',
			value: "{{ Carbon\Carbon::now()->format('Y/m/d') }}",
			startDate:	"{{ Carbon\Carbon::now()->format('Y/m/d') }}",
		});

		$('#incident_time').datetimepicker({
			lang:'en',
			datepicker:false,
			mask: '29:59',
			formatTime:'H:i',
			format:'H:i',
			step:5,
			value: "{{ Carbon\Carbon::now()->format('H:i') }}",
		})

		$('#date_opened').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			timepicker: false,
			lang:'en',
			format:'Y/m/d',
			formatDate:'Y/m/d',
			value: "{{ Carbon\Carbon::now()->format('Y/m/d') }}",
			startDate:	"{{ Carbon\Carbon::now()->format('Y/m/d') }}",
		});

		$('#date_closed').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			timepicker: false,
			lang:'en',
			format:'Y/m/d',
			formatDate:'Y/m/d',
			
		});


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
						$('#cities_id').find('option').not(':first').remove();
						$('#cities_id').html(new_rows);

						$('#cities_id').val(num);
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