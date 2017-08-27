@extends('layouts.app')
@section('content')
<h2>&nbsp;Brokerage</h2>
<div class="pull-right">
  <a href = "{{ route('brokerageOrder') }}" class = "btn but btn-md pull-right">New Brokerage Service Order</a>
</div>
<br/>
<hr>
<div class="container-fluid">
  <div class="row">
    <div class = "panel-default panel">
      <div class="panel-heading" id="heading">Select Service Order</div>
      <div class="panel-body">
       <table class="table table-responsive" id = "cs_table">
        <thead>
          <tr>
            <td width="20%">
              No.
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
