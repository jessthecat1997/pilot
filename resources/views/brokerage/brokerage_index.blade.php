@extends('layouts.app')
@section('content')

<div>
<h3><img src="/images/bar.png"> Brokerage</h3>
<hr>
<a href = "{{ route('newserviceorder.create') }}" class = "btn btn-success btn-md pull-right">New Brokerage Service Order</a>
<div class = "panel-body">
  <h4>Brokerage Service Orders</h4>
  <div class = "panel-default panel">
    <div class = "panel-body">
      <table class="table table-responsive" id = "cs_table">
        <thead>
          <tr>
            <td width="20%">
              id
            </td>
            <td>
              Company Name
            </td>
            <td width="20%">
              Shipper
            </td>
            <td width="10%">
              Freight Type
            </td>
            <td width="10%">
              Status Type
            </td>
            <td width="10%">
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
	.brokerage
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
	$('#collapse1').addClass('in');
  var data;
  var current_route = "";
  $(document).ready(function(){
    var cstable = $('#cs_table').DataTable({
      responsive: true,
      scrollX: true,
      scrollX: "100%",
      processing: true,
      serverSide: true,
      ajax: '{{ route("br.data") }}',
      columns: [
      { data: 'id' },
      { data: 'companyName'},
      { data: 'shipper'},
      { data: 'freightType'},
      { data: 'statusType'},
      { data: 'action', orderable: false, searchable: false }
      ],

    });
  })
  </script>
@endpush
