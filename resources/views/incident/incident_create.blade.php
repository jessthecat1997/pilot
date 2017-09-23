@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>&nbsp;New Incident</h2>
		</div>
		<div class="panel-body">
			<form>
				<div class="col-md-5">
					<div class="row">
						<div class="form-group">
							<label class="control-label">Incident Date</label>
							<input type="date" class = "form-control" name="incident_date">
						</div>
						<div class="form-group">
							<label class="control-label">Time</label>
							<input type="date" class = "form-control" name="">
						</div>
						<div class="form-group">
							<label>Date Opened</label>
							<input type="date" class = "form-control" name="">
						</div>
						<div class="form-group">
							<label>Date Closed</label>
							<input type="date" class = "form-control" name="">
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label>Province</label>
							<select class = "form-control" id = "loc_province">
								@forelse($provinces as $province)
								<option value = "{{ $province->id }}">{{ $province->name }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group">
							<label>City</label>
							<select class = "form-control" id = "loc_city"></select>
						</div>
						<div class="form-group">
							<label>Delivery</label>
							<select class = "form-control">
								@forelse($deliveries as $delivery)
								<option value="{{ $delivery->id }}">{{ $delivery->plateNumber }} - {{ Carbon\Carbon::parse($delivery->deliveryDateTime)->toFormattedDateString() }}</option>
								@empty

								@endforelse
							</select>
						</div>
						<div class="form-group">
							<label>Fine</label>
							<input type="number" class = "form-control" name="" style="text-align: right;">
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea class = "form-control"></textarea>
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

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','.save-incident', function(e){
			e.preventDefault();

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