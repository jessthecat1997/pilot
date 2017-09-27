@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>&nbsp;Incident <small>{{ $incident->id }}.</small><button class="btn but btn-sm pull-right btn-md back_view" style="width:15%;">Back</button></h4>
		</div>
		<div class="panel-body">
			<form id = "commentForm">
				{{ csrf_field() }}
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Incident Date:</label>
							<span class="control-label col-md-8">{{ Carbon\Carbon::parse($incident->incident_date)->format('F d, Y') }}</span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Time:</label>
							<span class="control-label col-md-8">{{ Carbon\Carbon::createFromFormat('H:i:s', $incident->incident_time)->format('g:i a') }}</span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Date Opened:</label>
							<span class="control-label col-md-8">{{ Carbon\Carbon::parse($incident->date_opened)->format('F d, Y') }}</span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Date Closed:</label>
							@if($incident->date_closed == null)
							<span class="control-label col-md-8">Not set</span>
							@else
							<span class="control-label col-md-8">{{ Carbon\Carbon::parse($incident->date_opened)->format('F d, Y') }}</span>
							@endif
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Address:</label>
							<span class="control-label col-md-8">{{ $incident->address }}</span>
						</div>
						<br />
						<div class="row">

							<label class="control-label col-md-4" style="text-align: right;">City:</label>
							@if($incident->cities_id == null)
							<span class="control-label col-md-8"></span>
							@else
							<span class="control-label col-md-8">{{ $location[0]->city . " " . $location[0]->province}}</span>
							@endif
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Delivery:</label>
							@if($incident->delivery_id == null)
							<span class="control-label col-md-8">Not set</span>
							@else
							<span class="control-label col-md-8">{{ $incident->delivery_id }}</span>
							@endif
							
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Fine:</label>
							<span class="control-label col-md-8">Php <span class="money">{{ $incident->fine }}</span></span>
						</div>
						<br />
						<div class="row">
							<label class="control-label col-md-4" style="text-align: right;">Description: </label>
							<span class="control-label col-md-8">{{ $incident->description }}</span>
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
			window.location.href = "{{ route('employees.index') }}/{{ $incident->employees_id }}/view";
		})
	})
</script>
@endpush