@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div clas= "col-md-12">
		<h2>&nbsp; Back up and Recovery</h2>
		<hr />
		<ul class="nav nav-pills">
			<li class="active"><a data-toggle="pill" href="#home">Backup</a></li>
			<li><a data-toggle="pill" href="#menu1">Recovery</a></li>
		</ul>

		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<br />
				<div class="col-md-4">
					<div class="row">
						Latest Backup
						<br />
						<h4 style="text-align: center;"><strong>{{ Carbon\Carbon::now('Asia/Hong_Kong')->format('F d, Y h:i:s A') }}</strong></h4>
						<br />
						Backup History
						<div class="col-md-12">
							<table class="table table-responsive table-striped table-bordered">
								<tr>
									<td>
										Date
									</td>
								</tr>
								<tr>
									<td>
										{{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(-1)->format('F d, Y h:i:s A') }}
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="row">

					</div>
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="panel panel-default">
							<div class="panel-heading">
								Automatic Scheduled Backup
							</div>
							<div class="panel-body">
								Create a backup for the system during the set time.
								<br />
								<br />
								Status: Scheduled at {{ Carbon\Carbon::now('Asia/Hong_Kong')->format('F d, Y') }} 5:00 PM.
								<br />
								<br />
								<div class="row">
									<div class="col-md-12">
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="panel panel-default">
							<div class="panel-heading">
								Manually Backup
							</div>
							<div class="panel-body">
								Create a backup any time of the day.
								<br />
								<br />
								<button class="btn btn-success">Start System Backup</button>
								<br />
								<br />
								<div class="row">
									<div class="col-md-12">
										<div class="progress">
											<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="menu1" class="tab-pane fade">
				<br />
				<div class = "col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							Recover
						</div>
						<div class="panel-body">
							This will restore the system to the latest copy of the backup. {{ Carbon\Carbon::now('Asia/Hong_Kong')->addDays(-1)->format('F d, Y h:i:s A') }}
							<br />
							<br />
							<button class="btn btn-success">Start System Recovery</button>
							<br />
							<br />
							<div class="row">
								<div class="col-md-12">
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="menu2" class="tab-pane fade">
				<h3>Menu 2</h3>
				<p>Some content in menu 2.</p>
			</div>
		</div>
	</div>
</div>
@endsection