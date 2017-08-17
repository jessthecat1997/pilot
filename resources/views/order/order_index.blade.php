@extends('layouts.app')
@section('content')
<h2>&nbsp;Orders</h2>
<hr>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-5">
			<div class="panel-heading" id="heading">ORDER: 1</div>
			<div class="panel-body">
				<div class="col-sm-12">
					<div class="col-sm-3">
						<div class="form-group">
							<label>Name:</label>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<label>Skipper Igcasenza</label>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="vat">Company:</label>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<label for="vat">Golden State Warriors</label>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<div class="form-group">
							<label for="vat">Address:</label>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<label for="vat">55A Villa Concio St. San Joaquin, Pasig City</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-7">
			<div class="panel-heading" id="heading">DELIVERY</div>
			<div class="panel-body">
			</div>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-5">
			<div class="panel-heading" id="heading">NOTES</div>
			<div class="panel-body">
			</div>
		</div>
		<div class="col-sm-7">
			<div class="panel-heading" id="heading">REVENUE</div>
			<div class="panel-body">
			</div>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-5">
		</div>
		<div class="col-sm-7">
			<div class="panel-heading" id="heading">EXPENSE</div>
			<div class="panel-body">
			</div>
		</div>
	</div>
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