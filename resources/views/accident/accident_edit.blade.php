@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>&nbsp;Edit Accident <small>{{ $accident->id }}</small></h4>
		</div>
		<div class="panel-body">
			<form id = "commentForm">
				{{ csrf_field() }}
				<div class="col-md-5">
					<div class="row">
						<div class="form-group required">
							<label class="control-label">Incident Date</label>
							<input type="text" class = "form-control" name="incident_date" id = "incident_date" value="">
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
							<textarea class="form-control" name="address" id="address">{{ $accident->address }}</textarea>
						</div>
						<div class="form-group">
							<label class="control-label">Province</label>
							<select class = "form-control" id = "loc_province">
								<option></option>
								@forelse($provinces as $province)
								<option value = "{{ $province->id }}">{{ $province->name }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">City</label>
							<select class = "form-control" id = "cities_id"></select>
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
							<input type="number" class = "form-control" name = "numberOfInjuries" id = "numberOfInjuries" min = "0" max = "99999999999" value="{{ $accident->numberOfInjuries }}">
						</div>
						<div class="form-group required">
							<label class="control-label">No. of Fatalities</label>
							<input type="number" class = "form-control" name = "numberOfFatalities" id = "numberOfFatalities"  min = "0"  max = "99999999999" value="{{ $accident->numberOfFatalities }}">
						</div>
						<div class="form-group required">
							<label class="control-label">Property Damage</label>
							<div class="input-group">
								<span class="input-group-addon">Php</span>
								<input type="text" class="form-control money"  id = "propertyDamage" name = "propertyDamage" data-rule-required="true" style = "text-align: right" value = "{{ $accident->propertyDamage }}" required >
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label">Description</label>
							<textarea class = "form-control" name="description" id = "description">{{ $accident->description }}</textarea>
						</div>
						<div class="form-group">
							<button type = "button" class="btn but btn-md save-incident" style="width: 100%;">Save</button>
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
		//Set data
		@if($accident->delivery_id != null) $('#delivery_id').val("{{ $accident->delivery_id }}"); @endif
		@if($accident->cities_id != null) $('#loc_province').val("{{ $city->provinces_id }}"); fill_cities("{{ $city->provinces_id }}"); $('#cities_id').val("{{ $accident->cities_id }}"); @endif



		$(document).on('click','.save-incident', function(e){
			e.preventDefault();
			$('#incident_date').valid();
			$('#incident_time').valid();
			$('#date_opened').valid();
			$('#description').valid();
			$('#numberOfFatalities').valid();
			$('#numberOfInjuries').valid();
			if($('#incident_date').valid() && $('#incident_time').valid() && $('#date_opened').valid() && $('#description').valid() && $('#numberOfFatalities').valid() && $('#numberOfInjuries').valid()){
				$.ajax({
					type: 'PUT',
					url:  '{{ route("employees.index") }}/{{ $employee->id }}/accidents/{{ $accident->id }}',
					data: {
						'_token' : $('input[name=_token').val(),
						'incident' : "{{ $accident->id }}",
						'incident_date' : $('#incident_date').val(),
						'incident_time' : $('#incident_time').val(),
						'date_opened' : $('#date_opened').val(),
						'date_closed' : ($('#date_closed') === '____/__/__') ? null :$('#date_closed').val() ,
						'address' : $('#address').val(),
						'cities_id' : $('#cities_id').val(),
						'delivery_id' : $('#delivery_id').val(),
						'numberOfFatalities' : $('#numberOfFatalities').val(),
						'numberOfInjuries' : $('#numberOfInjuries').val(),
						'propertyDamage' : $('#propertyDamage').inputmask('unmaskedvalue'),
						'description' : $('#description').val(),
						'employees_id' : {{ $employee->id }},
					},
					success: function (data)
					{
						window.location.href = "{{ route('employees.index') }}/{{ $employee->id }}/view";
					}
				})
			}
		})

		$("#commentForm").validate({
			rules: 
			{
				time:
				{
					required: true,
				},

				date_opened:
				{
					required: true,
					date: true,
				},

				description:
				{
					required: true,
				},

				numberOfInjuries:
				{
					required: true,
					number: true,
				},

				numberOfFatalities:
				{
					required: true,
					number: true,
				}
			},
			onkeyup: false, 
			submitHandler: function (form) {
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
			value: "{{ Carbon\Carbon::parse($accident->incident_date)->format('Y/m/d') }}",
			startDate:	"{{ Carbon\Carbon::parse($accident->incident_date)->format('Y/m/d') }}",
		});

		$('#incident_time').datetimepicker({
			lang:'en',
			datepicker:false,
			mask: '29:59',
			formatTime:'H:i',
			format:'H:i',
			step:5,
			value: "{{ Carbon\Carbon::createFromFormat('H:i:s', $accident->incident_time)->format('H:i') }}",
			startDate:	"{{ Carbon\Carbon::createFromFormat('H:i:s', $accident->incident_time)->format('H:i') }}",
		})

		$('#date_opened').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			timepicker: false,
			lang:'en',
			format:'Y/m/d',
			formatDate:'Y/m/d',
			value: "{{ Carbon\Carbon::parse($accident->date_opened)->format('Y/m/d') }}",
			startDate:	"{{ Carbon\Carbon::parse($accident->date_opened)->format('Y/m/d') }}",
		});

		$('#date_closed').datetimepicker({
			mask:'9999/19/39',
			dayOfWeekStart : 1,
			timepicker: false,
			lang:'en',
			format:'Y/m/d',
			formatDate:'Y/m/d',
			@if($accident->date_closed != null)
			value: "{{ Carbon\Carbon::parse($accident->date_closed)->format('Y/m/d') }}",
			startDate:	"{{ Carbon\Carbon::parse($accident->date_closed)->format('Y/m/d') }}",
			@endif
			
		});

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

						var new_rows = "<option></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#cities_id').find('option').not(':first').remove();
						$('#cities_id').html(new_rows);

						$('#cities_id').val("{{ $accident->cities_id }}");
						
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