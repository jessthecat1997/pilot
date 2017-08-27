@extends('layouts.app')
@push('styles')
<style type="text/css">
	span.control-label {
		font-size: 20px;
	}
	span.label {
		font-size: 15px;
	}
	strong {
		font-size: 15px;
	}
</style>
@endpush

@section('content')
<div class = "row">

		<div class = "panel-heading">
			<h2>&nbsp;Manage Trucking</h2>
			<hr/>
		</div>
		<div class = "panel-body panel">
			<div class="col-md-12">
				<h4>Brokerage Information <button class="btn btn-sm btn-primary pull-right clearfix edit-trucking-information" data-toggle="modal" data-target="#trModal">Update Brokerage Status</button></h4>

				<br />
				<table class="table">
					<tbody>
						<tr>
							<td class="active"><strong>Brokerage Service Order #: </strong></td>

							<td class = "success" id="consignee"><strong>{{ $brokerage_id }}</strong></td>
							<td class="success">

							</td>
						</tr>
						<tr>
							<td class="active"><strong>Consignee: </strong></td>
							<td class="success" id="address"><strong>{{ $brokerage_header[0]->firstName  . " " . $brokerage_header[0]->lastName }}</strong></td>
							<td class="success"></td>
						</tr>
						<tr>
							<td class="active">
                <strong>Company Name: </strong>
              </td>

							<td class="success" id="sotype"><strong>{{ $brokerage_header[0]->companyName }}</strong></td>
							<td class="success">
							</td>
						</tr>
						<tr>
							<td class="active"><strong>Status: </strong></td>
							<td class="success">

							</td>
							<td class="success">
							</td>
						</tr>
						<tr>
							<td class="active">
								<strong>Estimated Delivery Fee: </strong>
							</td>

							<td class="success" colspan="2">
								<strong>Php </strong>
							</td>
						</tr>
						<tr>
              <tr>
                <td>
                  <label class = "control-label" id = "shipper"> Shipper: @php echo $brokerage_header[0]->shipper @endphp </label>
                </td>
                <td>
                  <label class = "control-label" id = "blNo"> Shipper: @php echo $brokerage_header[0]->freightBillNo @endphp </label>
                </td>
                <td>
                    <label class = "control-label" id = "weight"> Weight: @php echo $brokerage_header[0]->Weight @endphp (kgs)</label>
                </td>
              </tr>
              <tr>
                <td>
                  <label class = "control-label" id = "arrivalDate"> Arrival: @php echo $brokerage_header[0]->expectedArrivalDate @endphp </label>
                </td>
                <td>
                  <label class = "control-label" id = "port"> Port: @php  echo $brokerage_header[0]->name @endphp  </label>
                </td>

              </tr>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class = "row">
		<div class = "panel default-panel">
			<div class = "panel-body">

				<h4>Duties and Taxes Decleration <button class = "btn btn-md btn-success col-md-5 pull-right" id = "newDutiesAndTaxes">New Duties and Taxes</button></h4>
				<hr />
				<table class = "table table-responsive" id = "dutiesandtaxes_table">
					<thead>
						<tr>
							<td style="width: 5%;">
								ID
							</td>
							<td style="width: 10%;">
							  Exchange Rate
							</td>
							<td style="width: 10%;">
								Processed By
							</td>
							<td style="width: 15%;">
								Actions
							</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>

</div>
<div class="modal fade" id="confirm-create" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Create Bill
			</div>
			<div class="modal-body">
				Confirm Creating new Bill
			</div>
			<div class="modal-footer">

				<button class = "btn btn-success confirm-create-bill">Confirm</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class = "row">

		<div class = "panel">
			<div class = "panel-body">

				<h4>List of Revenues <button class = "btn but new_revenue pull-right">New Revenue</button></h4>


				<br />

				<table class="table table-responsive" style="width: 100%;" id = "revenues_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>

							</td>
							<td>

							</td>
							<td>

							</td>
						</tr>
					</tbody>
				</table>

				<div class = "form-horizontal">
					<div class = "col-md-10">
						Create Billing First to Add Payables.
					</div>
					<div class="col-md-2">
						<button class = "btn but new_revenue_bill btn-sm">New Bill</button>
					</div>
				</div>

			</div>
		</div>

</div>

<div class = "row">

		<div class = "panel">
			<div class = "panel-body">

				<h4>List of Expenses <button class = "btn but new_expense pull-right">New Expense</button></h4>


				<br />

				<table class="table table-responsive" style="width: 100%;" id = "expense_table">
					<thead>
						<tr>
							<td>
								Name
							</td>
							<td>
								Description
							</td>
							<td>
								Amount
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>

							</td>
							<td>

							</td>
							<td>

							</td>
						</tr>
					</tbody>
				</table>

				<div class = "form-horizontal">
					<div class = "col-md-10">
						Create Billing First to Add Payables.
					</div>
					<div class="col-md-2">
						<button class = "btn but new_expense_bill btn-sm">New Bill</button>
					</div>
				</div>

			</div>
		</div>

</div>

<div id="revModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Payable</h4>
			</div>
			<div class = "modal-body">
				<div class = "col-md-12">
					<div class="form-horizontal">
						<div class = "col-md-6">
							<div class = "form-group">
								<label class = "control-label col-md-3">Name *</label>
								<div class = "col-md-9">
									<select id = "rev_bill_id" name="rev_bill_id" class = "form-control ">
										<option value = "0">Select Charges</option>

										<option value = ""></option>
									</select>
								</div>
							</div>
						</div>
						<div class = "col-md-6">
							<div class = "form-group">
								<label class = "control-label col-md-3">Amount *</label>
								<div class = "col-md-9">
									<input type = "text" name = "rev_amount" id="rev_amount" class = "form-control" style="text-align: right">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "col-md-12 collapse">
					<table style="width: 100%;" id = "delivery_fees_table">
						<thead>
							<tr style="width: 40%; text-align: center;">
								<td>
									Delivery No.
								</td>
								<td style="width: 60%; text-align: center;">
									Amount
								</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class = "col-md-12">
					<label for="rev_description">Description:</label>
					<textarea class="form-control" rows="3" id="rev_description" name="rev_description"></textarea>
				</div>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<a class="btn but finalize-rev">Save</a>
			</div>
		</div>
	</div>
</div>

<div id="expModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">New Payable</h4>
			</div>
			<div class = "modal-body">
				<div class = "col-md-12">
					<div class="form-horizontal">
						<div class = "col-md-6">
							<div class = "form-group">
								<label class = "control-label col-md-3">Name *</label>
								<div class = "col-md-9">
									<select id = "exp_bill_id" name="exp_bill_id" class = "form-control">
										<option value = "0">Select Charges</option>

										<option value = ""></option>

									</select>
								</div>
							</div>
						</div>
						<div class = "col-md-6">
							<div class = "form-group">
								<label class = "control-label col-md-3">Amount *</label>
								<div class = "col-md-9">
									<input type = "text" name = "exp_amount" id="exp_amount" class = "form-control" style="text-align: right">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "col-md-12 collapse">
					<table style="width: 100%;" id = "delivery_fees_table">
						<thead>
							<tr style="width: 40%; text-align: center;">
								<td>
									Delivery No.
								</td>
								<td style="width: 60%; text-align: center;">
									Amount
								</td>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class = "col-md-12">
					<label for="rev_description">Description:</label>
					<textarea class="form-control" rows="3" id="exp_description" name="exp_description"></textarea>
				</div>
				<strong>Note:</strong> All fields with * are required.
			</div>
			<div class="modal-footer">
				<a class="btn but finalize-exp">Save</a>
			</div>
		</div>
	</div>
</div>

<div id="deliveryModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Delivery Information</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					{{ csrf_field() }}
					<div class="form-group required">
						<label class="control-label col-sm-3" for="deliveryStatus">Delivery Status</label>
						<div class="col-sm-8">
							<select class = "form-control" name = "deliveryStatus" id = "deliveryStatus">
								<option value = "P">Pending</option>
								<option value = "C">Cancelled</option>
								<option value = "F">Finished</option>
							</select>
						</div>
					</div>
					<div class = "collapse delivery_remarks_collapse fade">
						<div class="form-group required">
							<label class="control-label col-sm-3" for="deliveryCancel">Date Cancelled</label>
							<div class="col-sm-8">
								<input type = "date" class = "form-control" name = "deliveryCancel" id = "deliveryCancel" />
							</div>
						</div>
						<div class="form-group required">
							<label class="control-label col-sm-3" for="deliveryRemarks">Remarks</label>
							<div class="col-sm-8">
								<textarea class = "form-control" name = "deliveryRemarks" id = "deliveryRemarks"></textarea>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success save-delivery-information" >Save</button>
				<button type="button" class="btn btn-danger close-delivery-information" data-dismiss = "modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="trModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Trucking Information</h4>
			</div>
			<div class="modal-body">
				<div class = "form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="_status">Status</label>
						<div class="col-sm-8">
							<select name = "_status" id = "_status" class = "form-control">
								<option value = "P">Pending</option>
								<option value = "C">Cancelled</option>
										<option value = "F" disabled title="There are still pending deliveries.">Finished</option>

								<option value = "F" >Finished</option>

							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success save-trucking-information" data-dismiss="modal">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
<link href= "/js/select2/select2.css" rel = "stylesheet">
@endpush
@push('scripts')
<script type = "text/javascript">

$('#newDutiesAndTaxes').on('click', function(e){
	window.location.replace('{{route("brokerage.index")}}/{{ $brokerage_id}}/create_dutiesandtaxes');
});

$(document).ready(function(){
  var dutiesandtaxes_table = $('#dutiesandtaxes_table').DataTable({
    processing: false,
    deferRender: true,
    serverSide: false,
    scrollX: true,
    ajax: '{{route("brokerage.index")}}/{{ $brokerage_id }}/get_dutiesandtaxes',
    columns: [

    { data: 'id' },
    { data: 'rate' },
    { data: 'processedBy'},
    { data: 'action', orderable: false, searchable: false }

    ],	"order": [[ 0, "desc" ]],
  });
})


</script>
@endpush
