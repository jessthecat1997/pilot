@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>&nbsp;Accident <small>{{ $accident->id }}.</small><button class="btn but btn-sm pull-right btn-md back_view" style="width:15%;">Back</button></h4>
		</div>
		<div class="panel-body">
			<form id = "commentForm">
				{{ csrf_field() }}
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Accident Date:</label>
							<span class="control-label col-md-8">{{ Carbon\Carbon::parse($accident->incident_date)->format('F d, Y') }}</span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Time:</label>
							<span class="control-label col-md-8">{{ Carbon\Carbon::createFromFormat('H:i:s', $accident->incident_time)->format('g:i a') }}</span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Date Opened:</label>
							<span class="control-label col-md-8">{{ Carbon\Carbon::parse($accident->date_opened)->format('F d, Y') }}</span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Date Closed:</label>
							@if($accident->date_closed == null)
							<span class="control-label col-md-8">Not set</span>
							@else
							<span class="control-label col-md-8">{{ Carbon\Carbon::parse($accident->date_opened)->format('F d, Y') }}</span>
							@endif
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Address:</label>
							<span class="control-label col-md-8">{{ $accident->address }}</span>
						</div>
						<br />
						<div class="row">

							<label class="control-label col-md-4" style="text-align: right;">City:</label>
							@if($accident->cities_id == null)
							<span class="control-label col-md-8"></span>
							@else
							<span class="control-label col-md-8">{{ $location[0]->city . " " . $location[0]->province}}</span>
							@endif
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Delivery:</label>
							@if($accident->delivery_id == null)
							<span class="control-label col-md-8">Not set</span>
							@else
							<span class="control-label col-md-8">{{ $accident->delivery_id }}</span>
							@endif
							
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Property Damage:</label>
							<span class="control-label col-md-8">Php <span class="money">{{ $accident->propertyDamage }}</span></span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Description: </label>
							<span class="control-label col-md-8">{{ $accident->description }}</span>
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
		$(document).on('click', '.back_view', function(e){
			e.preventDefault();
			window.location.href = "{{ route('employees.index') }}/{{ $accident->employees_id }}/view";
		})
	})
</script>
@endpush