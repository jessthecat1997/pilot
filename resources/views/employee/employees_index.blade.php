@extends('layouts.app')
@section('content')
<h2>&nbsp;Employees</h2>
<div class="pull-right">
  <a href = "{{ route('employees.create') }}" class = "btn but btn-md pull-right">New Employee</a>
</div>
<br/>
<hr>
<div class="container-fluid">
  <div class="row">
    <div class = "panel-default panel">
      <div class="panel-heading" id="heading">List of Employees</div>
      <div class="panel-body">
       <table class="table table-responsive" id = "cs_table">
        <thead>
          <tr>
            <td style = "width:50%"">
              Name
            </td>
            <td style="width: 40%;">
              Roles
            </td>
            <td style = "width: 10%">
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
	.employees
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
      serverSide: false,
      deferRender: true,
      ajax: '{{ route("employee.data") }}',
      columns: [
      { data: 'firstName' },
      { data: 'roles',
      "render": function(data, type, row){
        return data.split(",").join("<br/>");}
      },
      { data: 'action', orderable: false, searchable: false }
      ],
    });
  })
</script>
@endpush
