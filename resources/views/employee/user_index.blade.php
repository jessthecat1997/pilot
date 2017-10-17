@extends('layouts.app')
@section('content')

<h2>&nbsp;Users</h2>
<hr>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Users
			</div>
			<div class="panel-body">
				<table class = "table-responsive table" id="user_table">
					<thead>
						<tr>
							<th>
								Name
							</th>
							<th>
								Username
							</th>
							<th>
								Role
							</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>

	.class-billing
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">

	var data;



	$(document).ready(function(){

		var vtable = $('#user_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			ajax: "{{ route('users.data') }}",
			columns: [
			{ data: 'name' },
			{ data: 'email' },
			{ data: 'name' }
			]
		})
	})
</script>
@endpush
