@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div clas= "col-md-12">
		<h2>&nbsp; Back up and Recovery</h2>
		<hr />
		<div class="col-md-4">
			<div class="row">
				Last backup: {{ Carbon\Carbon::now()->format('F d, Y h:i:s A') }}
			</div>

			<div class="row">
				
			</div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						Scheduled backup
					</div>
					<div class="panel-body">
						Create a backup for the system during the 
						<br />
						<br />
						<button class="btn btn-md but">Create backup for database</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						Scheduled backup
					</div>
					<div class="panel-body">
						Create a backup for the system during the 
						<br />
						<br />
						<button class="btn btn-md but">Create backup for database</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">
						Scheduled backup
					</div>
					<div class="panel-body">
						Create a backup for the system during the 
						<br />
						<br />
						<button class="btn btn-md but">Create backup for database</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection