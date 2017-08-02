@extends('layouts.app')
@section('content')

<div class = "row">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h3><img src="/images/bar.png"> Brokerage | Create Service Order</h3>
				<hr />

			</div>


			<div class = "panel-body">
				<div class="panel-heading">
					<h4 id = "basic-information-heading" ><small>1</small>Consignee Information</h4>
				</div>
				<div class="panel-body">
					<div>
						<div class = "collapse in" id = "collapse_1">
              <div class="tab-content">
                <div class = "row">
                  <button class = "btn btn-success btn-md pull-right form-group" onclick="$('#ConsigneeModal').modal('show');"> New Consignee</a>
                </div>
								<div id="old_con" class="tab-pane fade in active form-group">
									<br />

									<table class="table table-responsive" id = "cs_table">
										<thead>
											<tr>
												<td width="20%">
													Full Name
												</td>
												<td width="20%">
													Company Name
												</td>
												<td width="20%">
													Email
												</td>
												<td width="10%">
													Contact Number
												</td>
												<td width="10%">
													Created At
												</td>
												<td width="10%">
													Actions
												</td>
											</tr>
										</thead>
									</table>

								</div>
								<div id="new_con" class="tab-pane fade">
									<br />

								</div>
							</div>
						</div>
						<div class = "collapse" id = "collapse_2">
							<div class = "col-md-12">
								<div class = "row form-horizontal">

										<div class="form-group">
											<label class="control-label col-sm-4" for="_firstName">Full Name:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_firstName" id="_firstName" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_companyName">Company Name: </label>
											<div class="col-sm-6">
												<input type="text" class="form-control"  disabled name = "_companyName" id="_companyName" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_consigneeType">Customer:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_consigneeType" id="_consigneeType" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_email">Email:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_email" id="_email" placeholder="Enter First Name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-sm-4" for="_contactNumber">Contact Number:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" disabled name = "_contactNumber" id="_contactNumber" placeholder="Enter First Name">
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "panel-heading">
					<h4><small>2</small>Brokerage Information</h4>
				</div>

	          <div class="panel-body">
	            <div class = "col-md-12">
	              <div class="form-horizontal">
	                <legend><h5>Service Order Details</h5></legend>
									<div class="form-group">
								 	<label class="col-md-2 control-label">Service Order Type*</label>
									<div class = "col-md-5">
										<div class = "input-group">
											<input id = "ServOrdText" type="text" class="form-control" aria-label="..." name = "serviceordertype" readonly>
											<div class="input-group-btn">
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Service Order Type <span class="caret"></span></button>
												<ul class="dropdown-menu dropdown-menu-right">
													<li><a href="#" onclick = "document.getElementById('ServOrdText').value = 'Brokerage'">Brokerage</a></li>
													<li class = "disabled"><a  href="#">Trucking</a></li>
													<li><a  href="#" "document.getElementById('ServOrdText').value = 'Brokerage and Trucking'">Brokerage and Trucking</a></li>
													</ul>
													</div>
												</div>
											</div>
										</div>
	                      <div class = "form-group">
	                        <label class="col-md-2 control-label">Expected Date Of Arrival</label>
	                        <div class="col-md-3">
	                            <input type="date" class = "form-control" name="arrivalDate" id = "arrivalDate">
	                        </div>
	                      </div>

	                      <div class = "form-group">
	                        <label  class="col-md-2 control-label">Freight Type*</label>
	                        <div class="col-md-5">
	                          <div class="input-group">
	                            <input id = "FreightType" type="text" class="form-control" aria-label="..." name = "freightType" readonly>
	                            <div class="input-group-btn">
	                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Freight Type <span class="caret"></span></button>
	                              <ul class="dropdown-menu dropdown-menu-right">
	                                <li><a href="#" onclick = "document.getElementById('FreightType').value = 'Air Freight'">Air Freight</a></li>
	                                <li><a href="#" onclick = "document.getElementById('FreightType').value = 'Sea Freight'">Sea Freight</a></li>
																	<li><a href="#" onclick = "document.getElementById('FreightType').value = 'Train Freight'">Train Freight</a></li>

																</ul>
	                            </div>
	                          </div>
	                        </div>
	                      </div>

												<div class="form-group">
														<label for="email" class="col-md-2 control-label">BL\AWL Number*</label>
														<div class="col-md-5">
																	<input  type="text" class="form-control" name = "freightnumber" id = "freightNumber">
														</div>
												</div>

	                      <div class="form-group">
	                          <label for="email" class="col-md-2 control-label">Port*</label>
	                          <div class="col-md-5">
	                                <input  type="text" class="form-control" name = "port" id = "port">
	                          </div>
	                      </div>

	                      <div class="form-group">
	                          <label  class="col-md-2 control-label">Shipper*</label>
	                          <div class="col-md-5">
	                                <input  type="text" class="form-control" name = "shipper" id = "shipper">
	                          </div>
	                      </div>

												<div class = "form-group">
													<label  class="col-md-2 control-label">Weight </label>
													<div class="col-md-5">
														<div class="input-group">
															<input  type="text" class="form-control" aria-label="..." name = "freightType" id = "weight">
															<div class="input-group-btn">
																<button type="button" class="btn btn-default" aria-expanded="false"> kgs</label>
															</div>
														</div>
													</div>
												</div>

	                      <div class="form-group">
	                          <label class="col-md-2 control-label">Description of goods</label>
	                          <div class="col-md-5">
	                                <textarea class="form-control" rows="3"></textarea>
	                          </div>
	                      </div>

	                      <legend ><h5>Duties and Taxes Details</h5></legend>

	                      <div class="form-group">
	                          <label class="col-md-2 control-label">Exhange Rate*</label>
	                            <div class="col-md-5">
	                                  <input  type="text" class="form-control" name = "exchangeRate" id = "exchangeRate">
	                          </div>
	                      </div>


	                      <div class="form-group">
													<label class="col-md-2 control-label">CDS Fee*</label>
													<div class = "col-md-5">
													<div class="input-group">
				  										<span class="input-group-addon" id="cdsfeeadd">Php</span>
				  										<input type="text" class="form-control"  aria-describedby="cdsfeeadd" id = "CDSFee">
														</div>
													</div>
	                      </div>

												<div class="form-group">
														<label class="col-md-2 control-label">IPF Fee*</label>
													<div class = "col-md-5">
													<div class="input-group">
				  										<span class="input-group-addon" id="ipffeeadd">Php</span>
				  										<input type="text" class="form-control"  aria-describedby="ipffeeadd" id = "IPFFee">
														</div>
													</div>
	                      </div>

	                      <div class="form-group">
	                        <div class = "panel panel-default table-responsive">
	                          <table id = "itemTable" class = "table table-hover table-responsive">
	                            <tr  class="info">
	                              <td>Item Name</td>
	                              <td>HS Code</td>
	                              <td>Rate Of Duty</td>
	                              <td>Value in USD</td>
																<td>Insurance</td>
	                              <td>Freight</td>
	                              <td>Action</td>
	                            </tr>
	                            <tr>
	                            </tr>
	                          </table>
	                          </div>
	                        </div>

	                        <button  type="reset" class="btn btn-default" onclick="$('#ItemModal').modal('show');">
	                          Add Item  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
	                        </button >
	                      </div>
	                      <hr>
	                    </div>
	                    <hr>
	                  <div class="form-group">

	                     <label class = "col-md-12 control-label">
	                       <button  class="btn btn-success" id = "generateDAT">
	                          Generate Duties And Taxes
	                       </button>

	                     </label>
	                     <p class = "col-md-12">Note: All fields with the '*' are required</p>
					</div>
		</div>





    <!-- New Consignee Modal -->
    <div class="modal fade" id="ConsigneeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Create Consignee</h4>
          </div>
					<form role = "form" class="form-horizontal" method = "POST" action = "/CreateConsignee">
          <div class="modal-body">
            	{{ csrf_field() }}
								<div class="form-group">
									<label class="control-label col-sm-4" for="firstName">Consignee:</label>
									<div class="col-sm-6">
										<select name = "consigneeType" id = "consigneeType" class="form-control">
											<option value = "0">
												Walk-in
											</option>
											<option value = "1">
												Regular
											</option>
										</select>
									</div>
								</div>

							<div class="form-group">
								<label class="control-label col-sm-4" for="firstName">First Name:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "firstName" id="firstName" placeholder="Enter First Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="middleName">Middle Name:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "middleName" id="middleName" placeholder="Enter Middle Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="pwd">Last Name:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "lastName" id="lastName" placeholder="Enter Last Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="companyName">Company Name:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "companyName" id="companyName" placeholder="Enter Company Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Email</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "email" id="email" placeholder="Enter Email Address">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="address">Address:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "address" id="address" placeholder="Enter Address">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="contactNumber">Contact Number:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
								</div>
							</div>
					</div>
          <div class="modal-footer">
            <input  type="submit" class="btn btn-success" value = "Create">
							<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
            <button type="button" class="btn btn-default" onclick = "$('#ConsigneeModal').modal('hide');">Close</button>
            </form>
          </div>
        </div>
      </div>
    </div>

		<!-- Add Item Modal -->
		<div class="modal fade" id="ItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" onclick="$('#ItemModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add Item</h4>
					</div>
					<div class="modal-body">
						<form class = "form-horizontal">
						<div class="form-group">
								<label class="col-md-3 control-label">Item Name</label>
									<div class="col-md-7">
												<input  type="text" class="form-control" id = "itemName">
								</div>
						</div>

						<div class="form-group">
								<label class="col-md-3 control-label">HS Code</label>
									<div class="col-md-7">
												<input  type="text" class="form-control" id = "HSCode">
								</div>
						</div>

						<div class="form-group">
								<label class="col-md-3 control-label">Rate Of Duty</label>
									<div class="col-md-7">
												<input  type="text" class="form-control" id = "RateOfDuty">
								</div>
						</div>

						<div class="form-group">
								<label class="col-md-3 control-label">Value</label>
							<div class = "col-md-7">
							<div class="input-group">
									<span class="input-group-addon" id="valuefeeadd">$</span>
									<input type="text" class="form-control"  aria-describedby="valuefeeadd" id = "Value">
								</div>
							</div>
						</div>

						<div class="form-group">
								<label class="col-md-3 control-label">Insurance</label>
							<div class = "col-md-7">
							<div class="input-group">
									<span class="input-group-addon" id="insuranceadd">$</span>
									<input type="text" class="form-control"  aria-describedby="insuranceadd" id = "Freight">
								</div>
							</div>
						</div>

						<div class="form-group">
								<label class="col-md-3 control-label">Freight</label>
							<div class = "col-md-7">
							<div class="input-group">
									<span class="input-group-addon" id="freightadd">$</span>
									<input type="text" class="form-control"  aria-describedby="freightadd" id = "Insurance">
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" id = "addItem" >Add</button>
						<input type = "reset" class = "btn btn-danger btn-md" value = "Clear" />
						<button type="button" class="btn btn-default" onclick="$('#ItemModal').modal('hide');">Close</button>
							</form>
					</div>
				</div>
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

  $(document).ready(function(){
  var cstable = $('#cs_table').DataTable({
    responsive: true,
    scrollX: true,
    scrollX: "100%",
    processing: true,
    serverSide: true,
    ajax: '{{ route("consignee.data") }}',
    columns: [

    { data: 'firstName' },
    { data: 'companyName' },
    { data: 'email' },
    { data: 'contactNumber' },
    { data: 'created_at' },
    { data: 'action', orderable: false, searchable: false }
    ],
  });

  $(document).on('click', '.selectConsignee' ,function(e){
    $('#collapse_1').removeClass('in');
    $('#collapse_2').addClass('in');
    data = cstable.row($(this).parents()).data();
    cs_id = data.id;
		localStorage.setItem("cs_id", cs_id);
    $('#_firstName').val(data.firstName);
    $('#_companyName').val(data.companyName);
    $('#_consigneeType').val(data.consigneeType);
    $('#_email').val(data.email);
    $('#_contactNumber').val(data.contactNumber);

    $("#basic-information-heading").html('<h4 id = "basic-information-heading"><small>1</small> Consignee Information<button class = "btn btn-sm btn-info changeConsignee 	pull-right">Change Consignee</button></h4>');
  })

  $(document).on('click', '.panel-title' , function(e){
    if($('#_firstName').val() == ""){
      $('#collapse_1').addClass('in');
      $('#collapse_2').removeClass('in');
    }
  })

  $(document).on('click', '.changeConsignee', function(e){
    $('#collapse_1').addClass('in');
    $('#collapse_2').removeClass('in');
    $('#_firstName').val("");
    $('#_companyName').val("");
    $('#_consigneeType').val("");
    $('#_email').val("");
    $('#_contactNumber').val("");

    $("#basic-information-heading").html('<h4 id = "basic-information-heading"><small>1</small> Consignee Information</h4>');

  })

  $('#btnConsigneeSave').on('submit', function(e){
    e.preventDefault();
    $.ajax({

      type: 'POST',
      url: '{{ route("createconsignee")}}',
      data: {
        '_token' : $('input[name=_token]').val(),
        'firstName' : $('#firstName').val(),
        'middleName' : $('#middleName').val(),
        'lastName' : $('#lastName').val(),
        'companyName' : $('#companyName').val(),
        'email' : $('#email').val(),
        'address' : $('#contactNumber').val(),
        'contactNumber' : $('#contactNumber').val(),
        'businessStyle' : $('#consigneeType').val(),

      },
      success: function (data) {
        if(typeof(data) == "object"){
          $('#collapse_1').removeClass('in');
          $('#collapse_2').addClass('in');
          $('#_firstName').val($('#firstName').val() + " " + $('#middleName').val() + " " + $('#lastName').val());
          $('#_companyName').val($('#companyName').val());

          cs_id = data.id;

          switch ($('#consigneeType').val()){
            case "0":
            $('#_consigneeType').val("Walk-in");
            break;
            case "1":
            $('#_consigneeType').val("Regular");
          }
          $('#_email').val($('#email').val());
          $('#_contactNumber').val($('#contactNumber').val());

          $("#basic-information-heading").html('<h5 id = "basic-information-heading">Basic Information <button class = "btn btn-sm btn-info changeConsignee 	pull-right">Change Consignee</button></h5>');

          cstable.ajax.reload();
          $('#firstName').val("");
          $('#middleName').val("");
          $('#lastName').val("");
          $('#companyName').val("");
          $('#email').val("");
          $('#address').val("");
          $('#contactNumber').val("");
        }
      }
    })

  });
	$('#addItem').on('click', function(e){
		var table = document.getElementById('itemTable');
		var row = table.insertRow();
		var cell0 = row.insertCell(0);
		var cell1 = row.insertCell(1);
		var cell2 = row.insertCell(2);
		var cell3 = row.insertCell(3);
		var cell4 = row.insertCell(4);
		var cell5 = row.insertCell(5);
		var cell6 = row.insertCell(6);
		cell0.innerHTML = document.getElementById('itemName').value;
		cell0.contentEditable = true;
		cell1.innerHTML = document.getElementById('HSCode').value;
		cell1.contentEditable = true;
		cell2.innerHTML = document.getElementById('RateOfDuty').value;
		cell2.contentEditable = true;
		cell3.innerHTML = document.getElementById('Value').value;
		cell3.contentEditable = true;
		cell4.innerHTML = document.getElementById('Freight').value;
		cell4.contentEditable = true;
		cell5.innerHTML = document.getElementById('Insurance').value;
		cell5.contentEditable = true;
		cell6.innerHTML = "<button class = 'btn btn-danger btn-md' onclick = 'clicked(this)' >Delete</button>";

		$('#ItemModal').modal('hide');
	});

	$('#generateDAT').on('click', function(e){

			var addedItems = new Array();
		  var table = document.getElementById('itemTable');
			var ctr = 0;
			localStorage.setItem("tblRowLength", table.rows.length);

		    for (var r = 0, n = table.rows.length; r < n; r++) {
		        for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
									addedItems[ctr] = table.rows[r].cells[c].innerHTML;
									ctr++;
						}
		    }

		localStorage.setItem("addedItems", JSON.stringify(addedItems));
		localStorage.setItem("itemCtr", ctr);

		localStorage.setItem("shipper", document.getElementById('shipper').value);
		localStorage.setItem("freightNumber", document.getElementById('freightNumber').value);
		localStorage.setItem("arrivalDate", document.getElementById('arrivalDate').value);
		localStorage.setItem("weight", document.getElementById('weight').value);
		localStorage.setItem("port", document.getElementById('port').value);
		localStorage.setItem("exchangeRate", document.getElementById('exchangeRate').value);
		localStorage.setItem("CDSFee", document.getElementById('CDSFee').value);
		localStorage.setItem("IPFFee", document.getElementById('IPFFee').value);
		localStorage.setItem("companyName",  document.getElementById('_companyName').value);
		localStorage.setItem("freightType",  document.getElementById('FreightType').value);

		window.location.replace("/dutiesandtaxes");

	});


	})






  </script>
@endpush
