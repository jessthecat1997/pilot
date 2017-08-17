@extends('layouts.app')
@section('content')
<h2>&nbsp;Quotations</h2>
<hr>
<div class="pull-right">
	<a href="{{ route('quotation.create') }}" role = "button" class = "btn but">Create New Quotation</a>
</div>
<br/>
<br/>
<div class = "container-fluid">
	<div  class = "row">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<table class = "table table-responsive" id = "quotation_table">
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
@endsection
@push('styles')
<style>
	.quotation
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
	$(document).ready(function(){
		var chtable = $('#quotation_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			ajax: '{{ route("quotation_data") }}',
			columns: [
			
			{ data: 'id' },
			{ data: 'name' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "desc" ]],
		});

		$(document).on('click', '.view', function(e){
			e.preventDefault();
			window.location.href = "{{ route('quotation.index') }}/" + $(this).val();
		})

		$(document).on('click', '.print', function(e){
			e.preventDefault();
			window.open("{{ route('quotation.index') }}/" + $(this).val() + "/print");
		})
	})
</script>
@endpush