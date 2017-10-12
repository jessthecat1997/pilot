@extends('layouts.app')
@section('content')
<h2>&nbsp;Quotations</h2>
<hr>
<div class="pull-right">
	<a href="{{ route('quotation.create') }}" role = "button" class = "btn btn-primary">Create New Quotation</a>
</div>
<br/>
<br/>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				List of Quotations
			</div>
			<div class="panel-body">
				<table class = "table-responsive table table-striped table-bordered" id="quotation_table" style="width: 100%;">
					<thead>
						<tr>
							<th>
								Quotation No.
							</th>
							<th>
								Consignee
							</th>
							<th>
								Status
							</th>
							<th>
								Created At
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse($quotations as $quot)
						<tr>
							<td>
								{{ $quot->id }}
							</td>
							<td>
								{{ $quot->name }}
							</td>
							<td>
								@if( $quot->con_head != null)
								<a href = "{{ route('trucking.index') }}/contracts/{{ $quot->con_head }}/view">Contract : {{ $quot->con_head }}</a>
								@else
								Not Accepted
								@endif
							</td>
							<td>
								{{ Carbon\Carbon::parse($quot->created_at)->format('F d, Y') }}
							</td>
							<td>
								<button value = "{{ $quot->id }}" class = "btn btn-md but view">View</button>
								<button value = "{{ $quot->id }}" class = "btn btn-md btn-success print">Print</button>
								<button value = "{{ $quot->id }}" class = "btn btn-md btn-danger archive">Archive</button>
							</td>
						</tr>
						@empty

						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="confirm-delete" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Deactivate record
			</div>
			<div class="modal-body">
				Confirm Archiving this quotation
			</div>
			<div class="modal-footer">
				{{ csrf_field() }}
				<button class = "btn btn-danger	" id = "btnDelete" >Archive</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
	var selected_id = 0;
	$(document).ready(function(){
		var chtable = $('#quotation_table').DataTable({
			processing: false,
			deferRender: true,
			serverSide: false,
			//ajax: '{{ route("quotation_data") }}',
			columns: [
			
			{ data: 'id' },
			{ data: 'name' },
			{ data: 'created_at' },
			{ data: 'con_head' },
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

		$(document).on('click', '.archive', function(e){
			$('#confirm-delete').modal('show');	
			selected_id = $(this).val();
		})

		$(document).on('click', '#btnDelete', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '{{ route("quotation.index")}}/' + selected_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					chtable.ajax.reload();
					$('#confirm-delete').modal('hide');

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 2000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr["success"]("Record deactivated successfully")
				}
			})

			chtable.ajax.reload();
		})
	})
</script>
@endpush