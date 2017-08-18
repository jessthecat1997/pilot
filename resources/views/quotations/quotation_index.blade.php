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