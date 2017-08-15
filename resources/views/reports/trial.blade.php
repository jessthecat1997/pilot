@extends('layouts.app')
@section('content')

<h3><img src="/images/bar.png"> Reports |Trial</h3>
<hr>
<div class = "container-fluid">
	<div class="row">
		<div class = "panel-default panel">
			<div  width="50px" height="50px">
				<canvas id="lineChart" >
					
				</canvas>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
	const CHART = document.getElementById("lineChart"); 
	console.log(CHART);
	let lineChart = new Chart(CHART, {
		type: 'line', //string
		data: {
			labels:["January", "February", "March", "April", "May", "June", "July"],
			datasets:[
			{
				label:"My First dataset",
				fill:false,
				lineTension: 0.1,
				backgroundColor:"rgba(75,192,192,0.4)",
				borderColor: "rgba(75,192,192,1)",
				borderCapStyle: 'butt',
				borderDash:[],
				borderDashOffset:0.0,
				borderJoinStyle:'miter',
				pointBorderColor: "rgba(75,192,192,1)",
				pontBorderWidth: 1,
				pointHoverRadius:5,
				pointHoverBackgroundColor:"rgba(75,192,192,1)",
				pointHoverBorderColor:"rgba(220,220,1)",
				pointHoverBorderWidht:2,
				pointRadius:1,
				pointHitRadius: 10,
				data:[ 65, 59, 80, 81, 56, 55, 40],
			},
			{
				label:"My Second dataset",
				fill:true,
				lineTension: 0,
				backgroundColor:"rgba(75,75,192,0.4)",
				borderColor: "rgba(75,192,192,1)",
				borderCapStyle: 'butt',
				borderDash:[],
				borderDashOffset:0.0,
				borderJoinStyle:'miter',
				pointBorderColor: "rgba(75,192,192,1)",
				pontBorderWidth: 1,
				pointHoverRadius:5,
				pointHoverBackgroundColor:"rgba(75,192,192,1)",
				pointHoverBorderColor:"rgba(220,220,1)",
				pointHoverBorderWidht:2,
				pointRadius:1,
				pointHitRadius: 10,
				data:[ 25, 22, 33, 11, 56, 55, 40],
			}
			]

		}

	});
</script>
@endpush