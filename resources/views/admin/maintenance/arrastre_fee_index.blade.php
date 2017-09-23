@extends('layouts.maintenance')
@push('styles')
<style>
	.class-arrastre-fee
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
	.maintenance
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Brokerage | Arrastre Fee</h2>
		<hr>

		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#wharfageFeeModal" style = "width: 100%;">New Arrastre Fee</button>
		</div>
	</div>
    <br/>
  <div class = "row">
    <div class = "panel-default panel">
      <div class = "panel-body">
        <table class = "table-responsive table" id = "Cargo_Type">
          <thead>
            <tr>
              <td>
                Fee
              </td>
              <td>
                Date Effective
              </td>
              <td>
                Actions
              </td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush
