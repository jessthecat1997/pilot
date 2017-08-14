@extends('layouts.app')
@section('content')

<h3><img src="/images/bar.png"> Reports |Trial</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<h3>Reference purposes</h3>
				<div id="chart-div" ></div>
					{!! $lava->render('PieChart', 'IMDB', 'chart-div') !!}
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
@endpush