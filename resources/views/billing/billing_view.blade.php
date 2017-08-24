@extends('layouts.app')
@section('content')
<h2>&nbsp;Billing</h2>
<div class="pull-left">
	<a href="/billing" class="btn but">Back</a>
</div>
<br/>
<hr>
<div class = "container-fluid">
	<div class="row">
		
	</div>
	<hr>
	
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
	$('#collapse1').addClass('in');
	var data;
	$(document).ready(function(){
		
		var vtable = $('#brso_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("brso_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
		var trtable = $('#trso_head_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("trso_head.data") }}',
			columns: [
			{ data: 'id' },
			{ data: 'companyName' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false, processing:false }
			]
		})
		
	})
</script>
@endpush