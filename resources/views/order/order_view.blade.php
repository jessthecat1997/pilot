@extends('layouts.app')
@section('content')
<h2>&nbsp;Order <small><strong>{{ $so_head[0]->id }}</strong></small>.</h2>
<hr>
<div class="container-fluid">
	<form>
		<div class = "row">
			<div class = "col-md-5">
				<div class="panel">
					<div class="panel-heading heading">
						Order Information
					</div>
					<div class="panel-body">
						<div class = "form-group">
							<label class="control-label col-md-4">Name</label>
							<div class = "col-md-8">
								{{ $so_head[0]->firstName }} {{ $so_head[0]->middleName }} {{ $so_head[0]->lastName }}
							</div>
						</div>
						<br />
						<div class = "form-group">
							<label class="control-label col-md-4">Company Name</label>
							<div class = "col-md-8">
								{{ $so_head[0]->companyName }}
							</div>
						</div>
						<br />
						<div class = "form-group">
							<label class="control-label col-md-4">Billing Address</label>
							<div class = "col-md-8">
								{{ $so_head[0]->b_address }} {{ $so_head[0]->b_city }} {{ $so_head[0]->b_st_prov }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "col-md-7">

			</div>
		</div>
	</form>
</div>
@endsection
@push('styles')
<style>
	.orders
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
</script>
@endpush