@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div  class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "panel default-panel">
				<div class  = "panel-heading">
					<h3>Quotations<a href="{{ route('quotation.create') }}" role = "button" class = "btn btn-success pull-right">Create New Quotation</a></h3>
					<hr />
				</div>
				<div class = "panel-body">
					<table class = "table table-responsive" id = "contracts_table">
						<thead>
							<tr>
								<td>
									Quotation No.
								</td>
								<td>
									Consignee
								</td>
								<td>
									Created At
								</td>
								<td>
									Action
								</td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('styles')
<style>
.quotation
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush