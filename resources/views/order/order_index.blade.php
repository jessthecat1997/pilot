@extends('layouts.app')
@section('content')
<div class = "col-md-12">
	<h2>&nbsp;Orders</h2>
	<hr />
	<div class="row">
		<div class="col-md-9">

		</div>
		<div class="col-md-3">
			<button class="btn btn-info" style="width: 100%;">New Order</button>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12">
			<table class = "table table-responsive table-striped" id = "order_table">
				<thead>
					<tr>
						<td style="width: 70%;">
							Consignee
						</td>
						<td>
							Created at
						</td>
						<td>
							Action
						</td>
					</tr>
				</thead>
				<tbody style="width: ">
					@forelse($orders as $order)
					<tr>
						<td>
							{{ $order->firstName }}
						</td>
						<td>
							{{ Carbon\Carbon::parse($order->created_at)->toFormattedDateString() }}
						</td>
						<td>
							<button class = 'btn btn-info view_order' title = 'Manage'>Manage</button>
							<input type = 'hidden' value = '{{ $order->id }}' class = 'order-id' />
						</td>
					</tr>
					@empty
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		var ordertable = $('#order_table').DataTable({
			processing: false,
			serverSide: false,
			deferRender: true,
			columns: [
			{ data: 'consignee' },
			{ data: 'created_at'},
			{ data: 'action', orderable: false, searchable: false }

			],	"order": [[ 0, "asc" ]],
		});

		$(document).on('click', '.view_order', function(e){
			e.preventDefault();
			window.location.href = "{{ route('orders.index') }}/" + $(this).closest('tr').find('.order-id').val();
		})
	})
</script>
@endpush