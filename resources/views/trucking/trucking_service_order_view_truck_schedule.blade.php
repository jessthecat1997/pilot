@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<h2>&nbsp;Available Trucks</h2>
	<div class = "col-md-10 col-md-offset-1">
		@forelse($vehicle_type_with_vehicles as $vt)
		<div class = "col-md-12">
			<div class = "panel panel-default">
				<div class = "panel-heading">
					{{ $vt['vehicle_type']->name }}
				</div>
				<div class = "panel-body">
					<table class="table table-responsive table-striped">
						<thead>
							<tr>
								<td>
									Plate Number
								</td>
								<td>
									Action
								</td>
							</tr>
						</thead>
						<tbody>
							@forelse($vt['vehicles'] as $vehicle)
							<tr>
								<td>
									{{ $vehicle->plateNumber}}
								</td>
								<td>

								</td>
							</tr>
							@empty

							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@empty

		@endforelse
	</div>
</div>
@endsection