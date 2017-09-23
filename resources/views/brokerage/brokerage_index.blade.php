@extends('layouts.app')
@section('content')
<h2>&nbsp;Brokerage</h2>
<div class="pull-right">
  <a href = "{{ route('brokerageOrder') }}" class = "btn btn-primary btn-md pull-right">New Brokerage Service Order</a>
</div>
<br/>
<hr>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Select Service Order
      </div>
      <div class="panel-body">
        <table class = "table-responsive table" id="cs_table">
          <thead>
            <tr>
              <th width="20%">
                No.
              </th>
              <th>
                Company Name
              </th>
              <th width="20%">
                Shipper
              </th>
              <th width="10%">
                Freight Type
              </th>
              <th width="10%">
                Status Type
              </th>
              <th width="10%">
                Action
              </th>
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
      processing: false,
      deferRender: true,
      serverSide: false,
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
