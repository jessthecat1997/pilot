@extends('layouts.app')
@section('content')
<h2>&nbsp;Brokerage</h2>
<hr>
<div class="row">
  <div class="col-lg-12">
    <div class = "collapse" id = "brokerage_warning">
     <div class="panel-body alert alert-danger">
       <div class = "col-md-12">
        <strong class = "col-md-10">Oops! We were unable to save your order due to some unforseen consequences</strong>
        <button class = "btn btn-danger col-md-1 pull-right" id = "exitPrompt" onclick = "resetMessages();"><small>X</small></button>
          <div class = "col-md-12">
            <li class = "collapse" id = "arrivalDateError"> > <a href = "#brokerageInformationHeader" style = "text-decoration: none; color: red;">Choose an expected date of arrival</a></li>
            <li class = "collapse" id = "freightTypeError"> > <a href = "#brokerageInformationHeader" style = "text-decoration: none; color: red;">Choose a freight type</a></li>
            <li class = "collapse" id = "BLError"> > <a href = "#brokerageInformationHeader" style = "text-decoration: none; color: red;">Input a BL/AWL Number</a></li>
            <li class = "collapse" id = "pickupError"> > <a href = "#brokerageInformationHeader" style = "text-decoration: none; color: red;">Select a pick up point</a></li>
            <li class = "collapse" id = "shipperError"> > <a href = "#shipper" style = "text-decoration: none; color: red;">Input shipper</a></li>
            <li class = "collapse" id = "weightError"> > <a href = "#shipper" style = "text-decoration: none; color: red;">Input weights</a></li>
            <li class = "collapse" id = "processedByError"> > <a href = "#shipper" style = "text-decoration: none; color: red;">Select an employee who processed this order</a></li>
          </div>
        </div>
      </div>
     </div>
      <ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle="pill" href="#home">Consignee Information</a></li>
        <li><a data-toggle="pill" href="#menu1">Brokerage Information</a></li>
        <li><a data-toggle="pill" href="#menu2">Container Information</a></li>
      </ul>
      <br />
      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Consignee Information
            </div>
            <div class="panel-body">
              <div class = "col-md-12">
                <div class = "col-md-6 col-md-offset-2">
                 <div class = "form-horizontal">
                  <div class = "form-group">
                   <label class = "control-label col-md-3">Consignee: </label>
                    <div class = "input-group col-md-9">
                        <select id = "consignee_id" class = "form-control select2-allow-clear select2">
                         <option value = "0">Select Consignee</option>
                         @forelse($consignees as $consignee)
                         <option value = "{{ $consignee->id }}">{{ $consignee->firstName . " " . $consignee->lastName . " - " . $consignee->companyName }}</option>
                         @empty
                         @endforelse
                        </select>
                    </div>
                   </div>
                 </div>
               </div>
               <div class = "col-md-4">
                 <button class = "btn btn-primary add_new_consignee" style="line-height: 10px; height: 28px;">New Consignee</button>
               </div>
               <div class="col-md-12">
                <div class = "form-horizontal">
                  <div class = "form-group">
                    <label class = "control-label col-md-3">Name: </label>
                    <div class = "col-md-9">
                      <div class = "col-md-4">
                        <input type = "text"  class = "form-control" id = "_cfirstName" disabled placeholder="First Name" />
                      </div>
                      <div class = "col-md-4">
                        <input type = "text"  class = "form-control" id = "_cmidddleName" disabled placeholder="Middle Name" />
                      </div>
                      <div class = "col-md-4">
                        <input type = "text"  class = "form-control" id = "_clastName" disabled placeholder="Last Name" />
                      </div>
                    </div>
                  </div>

                  <div class = "form-group">
                    <label class = "control-label col-md-3">Company Name</label>
                    <div class = "col-md-9">
                      <div class = "col-md-12">
                        <input type = "text"  class = "form-control" id = "_ccompanyName" disabled placeholder="Company" />
                      </div>
                    </div>
                  </div>
                  <div class = "form-group">
                    <label class = "control-label col-md-3">Business Style: </label>
                    <div class = "col-md-3">
                      <div class = "col-md-12">
                        <input type = "text"  class = "form-control" id = "_cbusinessStyle" disabled placeholder="Business Style" />
                      </div>
                    </div>
                    <label class = "control-label col-md-2">TIN: </label>
                    <div class = "col-md-4">
                      <div class = "col-md-12">
                        <input type = "text"  class = "form-control" id = "_cTIN" disabled placeholder="TIN" />
                      </div>
                    </div>
                  </div>
                </div>
               </div>
              </div>
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane fade">
         <div class="panel panel-primary">
          <div id = "brokerageInformationHeader" class="panel-heading">
            Brokerage Information
          </div>
          <div class="panel-body">
                    <form class="form">
                      {{ csrf_field() }}
                      <div class = "form-group">
                        <div class = "col-md-12">
                          <div class = "form-horizontal">

                          <div class = "form-group">
                            <label class= "col-md-4 control-label">Expected Arrival Date*</label>
                             <div class = "col-md-5">
                              <div class = "input-group">
                                  <input type="text" class = "form-control" name="expect" id = "expectedArrivalDate" data-msg="Please fill this field" disabled required>
                                  <span class="input-group-btn">
                                      <button class="btn btn-default" type="button" onclick="getData()" id = "arrivalDateButton"><i class="fa fa-calendar "></i></button>
                                  </span>
                              </div>
                            </div>
                          </div>

                          <div class = "form-group">
                            <label  class="col-md-4 control-label">Freight Type*</label>
                            <div class="col-md-5">
                              <div class="input-group">
                                <input id = "FreightType" type="text" class="form-control" aria-label="..." name = "freightType" data-msg="Please fill this field"  readonly required>
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Freight Type <span class="caret"></span></button>
                                  <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a onclick = "document.getElementById('FreightType').value = 'Air Freight'">Air Freight</a></li>
                                    <li><a	onclick = "document.getElementById('FreightType').value = 'Sea Freight'">Sea Freight</a></li>

                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                              <label for="email" class="col-md-4 control-label">BL\AWL Number*</label>
                              <div class="col-md-5">
                                    <input  type="text" class="form-control" name = "freightnumber" id = "freightNumber" data-msg="Please fill this field" required>
                              </div>
                          </div>

                          <div class="form-group">
                            <div class="form-group required">
                              <label class = "col-md-4 control-label ">Pick up point: </label>
                              <div class = "col-md-5">
                              <div class="input-group">
                                <select class = "form-control" id = "pickup_id" required data-msg="Please fill this field. Hint: Click on the plus sign to add a new location">
                                  <option value = "0"></option>
                                  @forelse($locations as $location)
                                  <option value = "{{ $location->id }}">{{ $location->name }}</option>
                                  @empty
                                  @endforelse
                                </select>
                                <span class="input-group-btn">
                                  <button class="btn btn-primary pick_add_new_location" onclick = "	$('#LocationModal').modal('show');"type="button">+</button>
                                </span>
                              </div>
                            </div>
                          </div>
                          </div>

                          <div class="form-group">
                              <label  class="col-md-4 control-label">Shipper*</label>
                              <div class="col-md-5">
                                    <input  type="text" class="form-control" name = "shipper" id = "shipper" required data-msg="Please fill this field">
                              </div>
                          </div>

                          <div class = "form-group">
                            <label  class="col-md-4 control-label">Weight </label>
                            <div class="col-md-5">
                              <div class="input-group">
                                <input  type="text" class="form-control" aria-label="..." name = "freightType" id = "weight" required data-msg="Please fill this field">
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-default" aria-expanded="false"> kgs</label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class = "form-group">
                            <label  class="col-md-4 control-label">Basis </label>
                            <div class="col-md-5">
                                <select class = "form-control" id = "basis" name="basis" >
                                  @forelse($basis as $basis_types)
                                  <option value = "{{ $basis_types->id }}">{{ $basis_types->name }}</option>
                                  @empty
                                  <option value = "No Cargo">No Basis Found</option>
                                  @endforelse
                                </select>
                            </div>
                          </div>
                          <div class = "form-group">
                            <label  class="col-md-4 control-label">Cargo Type </label>
                            <div class="col-md-5">
                                <select class = "form-control" id = "cargoType" name="cargoType" >
                                  <option value = "G">General Cargo</option>
                                  <option value = "C">Chemical</option>
                                </select>
                            </div>
                          </div>

                          <div class = "form-group">
                            <label  class="col-md-4 control-label">Certificate Of Origin </label>
                            <div class="col-md-5">
                              <input type="checkbox" data-toggle="toggle" data-size="normal" data-on="Included" data-off="Not Included" data-onstyle="success"  id = "withCO" width = "100px" >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
            </div>
          </div>
        </div>
        <div id="menu2" class="tab-pane fade">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Container Information
            </div>
            <div class="panel-body">
              <div id = "containerInfo" class = "tab-pane">
            <div class = "panel-heading">
              <h4 id = "containerInformationHeader"><small>3</small> Container Information</h4>
            </div>
            <div class = "panel-body">
              <ul class="nav nav-pills nav-justified" id = "choices">
                <li class="active"><a data-toggle="pill" href="#wcontainer">Container</a></li>
                <li><a data-toggle="pill" href="#wocontainer">Without Container</a></li>
              </ul>
              <br />
              <div class = "col-md-12">
                <div class = "col-md-12">
                  <div class="tab-content">
                    <div id="wcontainer" class="tab-pane fade in active">
                      <div class = "panel">
                        <div class = "">
                          <form class="form-horizontal" role="form">
                            {{ csrf_field() }}
                            <div class="row">
                              <div id = "containers">
                                <div class="panel-group" id = "container_copy">
                                  <div class="panel panel-default" id = "0_panel">
                                    <div class="panel-heading">
                                      <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#0_container ">Container</a>
                                        <div class="pull-right">
                                          <button class="btn btn-xs btn-info" data-toggle = "collapse" href="#0_container">_</button>
                                          <button class="remove-container-row btn btn-xs btn-danger" value = "0_panel">&times;</button>
                                        </div>
                                      </h4>
                                    </div>
                                    <div id="0_container" class="panel-collapse collapse in">
                                      <div class="panel-body">
                                        <div class = "row">
                                          <div class = "col-md-6">
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="contactNumber">Container Number:</label>
                                                <div class="col-sm-8">
                                                  <input type = "text" name = "containerNumber" id = "containerNumber" class = "form-control row_containerNumber" placeholder="CSQU3054383" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="contactNumber">Container Size:</label>
                                                <div class="col-sm-8">
                                                  <select class = "form-control row_containerVolume" id = "containerVolume" name = "containerVolume">
                                                    <option></option>
                                                    @forelse($container_volumes as $container_volume)
                                                    <option value = "{{ $container_volume->id }}">{{ $container_volume->name }}</option>
                                                    @empty

                                                    @endforelse
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="shippingLine">Shipping Line:</label>
                                                <div class="col-sm-8">
                                                  <input type = "text" name = "shippingLine" id = "shippingLine " class = "form-control row_containerReturnDate" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="contactNumber">Port of Cfs Location:</label>
                                                <div class="col-sm-8">
                                                  <input type = "text" name = "portOfCfsLocation" id = "portOfCfsLocation " class = "form-control row_containerReturnDate" />
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class = "col-md-6">
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="contactNumber">Return Date:</label>
                                                <div class="col-sm-8">
                                                  <input type = "date" name = "containerReturnDate" id = "containerReturnDate " class = "form-control row_containerReturnDate" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="contactNumber">Return To:</label>
                                                <div class="col-sm-8">
                                                  <input type = "text" name = "containerReturnTo" id = "containerReturnTo" class = "form-control row_containerReturnTo" />
                                                </div>
                                              </div>
                                            </div>
                                            <div class = "form-horizontal">
                                              <div class="form-group required">
                                                <label class="control-label col-sm-4" for="contactNumber">Return Address:</label>
                                                <div class="col-sm-8">
                                                  <textarea name = "containerReturnAddress" id = "containerReturnAddress " class = "form-control row_containerReturnAddress"></textarea>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class = "col-md-12">
                                          <table class="table table-responsive table-striped" id = "0_details">
                                            <thead>
                                              <tr>
                                                <td>
                                                  Description of goods
                                                </td>
                                                <td>
                                                  Gross Weight(kg)
                                                </td>
                                                <td>
                                                  Supplier/s
                                                </td>
                                                <td>
                                                  Action
                                                </td>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td width="35%">
                                                  <input type = "text" name = "0_descriptionOfGoods" class = "form-control"/>
                                                </td>
                                                <td width="20%">
                                                  <input type = "number" name = "0_grossWeight" class = "form-control"/>
                                                </td>
                                                <td width="30%">
                                                  <input type = "text" name = "0_supplier"  class = "form-control" />
                                                </td>
                                                <td width="15%">
                                                  <button class = "btn btn-md btn-danger remove-container-detail" value = "0">
                                                    x
                                                  </button>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                        <div class="row">
                                          <div class ="col-md-9">

                                          </div>
                                          <div class= "col-md-3" style="text-align: center;">
                                            <button class = "btn btn-primary btn-sm new-container-detail" style="width: 80%;" value = "0_add">New Good</button>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class= "col-md-3" style="text-align: center;">
                                <button class = "btn btn-primary btn-sm add-new-container" style="width: 80%;">New Container</button>
                              </div>
                              <div class ="col-md-9">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="wocontainer" class="tab-pane fade">
                      <div class = "panel">
                          <div class = "">
                            <form class="form-horizontal" role="form">
                              <div class="form-group">

                                <br />

                                <div class = "col-md-12">
                                  <label class="control-label" for="wodetail_table">Delivery Content:</label>
                                  <table class = "table-responsive table table-striped" id = "wodetail_table">
                                    <thead>
                                      <tr>
                                        <td>
                                          Description of Goods
                                        </td>
                                        <td>
                                          Less Cargo Load Type
                                        </td>
                                        <td>
                                          Gross Weight(kg)
                                        </td>
                                        <td>
                                          Supplier/s
                                        </td>
                                        <td>
                                          Action
                                        </td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr id = "wodescription_row">
                                        <td width="35%">
                                          <input type = "text" name = "wodescriptionOfGoods" class = "form-control"/>
                                        </td>
                                        <td width="35%">
                                          <select class = "form-control" id = "lcl_type" name="wolclTypes" >
                                            @forelse($lcl_types as $lcl_type)
                                            <option value = "{{ $lcl_type->id }}">{{ $lcl_type->name }}</option>
                                            @empty
                                            <option value = "No Cargo">No Less Cargo Type Found</option>
                                            @endforelse
                                          </select>
                                        </td>
                                        <td width="20%">
                                          <input type = "number" name = "wogrossWeight" class = "form-control"/>
                                        </td>
                                        <td width="30%">
                                          <input type = "text" name = "wosupplier"  class = "form-control" />
                                        </td>
                                        <td width="15%">
                                          <button class = "btn btn-md btn-danger woremove-current-detail">x</button>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="row">
                                  <div class="col-md-4">
                                    <button class = "btn btn-md btn-primary woadd-new-detail" style="width: 80%;">Add good</button>
                                  </div>
                                  <div class="col-md-8">

                                  </div>
                                </div>
                              </div>
                        </div>
                      </div>
                    </div>
                   </div>
                </div>
              </div>
            </div>
          </div>
            </div>
          </div>
          </div>

      </div>
        <br />
        <br />

        <button class = "btn btn-md btn-success ConfirmBut" style="width: 100%;" onclick = "	$('#ProcessedByModal').modal('show');" >Create Brokerage Service Order</button>
  </div>
</div>


<!--Add Consignee Modal -->
<section class = "content">
  <div id="chModal" class="modal fade" role="dialog">
	   <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Consignee Information</h4>
			</div>
			<div class="modal-body">
				<div class = "panel-default">
					<div id="con_collapse" class="collapse in">
						<ul class="nav nav-tabs">
							<li class = "active" ><a data-toggle="tab" href="#new_con">Basic Information</a></li>
							<li><a data-toggle="tab" href="#physical_address">Current Address</a></li>
							<li><a data-toggle="tab" href="#billing_address">Billing Address</a></li>
						</ul>

						<div class="tab-content">
  							<div id="physical_address" class="tab-pane fade in ">
  								<br />
  								<div class = "form-horizontal">
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="phy_address">Blk/Lot/Street:</label>
  										<div class="col-sm-8">
  											<input type="text" class="form-control" name = "phy_address" id="phy_address" placeholder="Enter Address">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="phy_province">Province:</label>
  										<div class="col-sm-8">
  											<select name = "phy_province" id="phy_province" class = "form-control">
  												<option value="0"></option>
  												@forelse($provinces as $province)
  												<option value="{{ $province->id }}" >
  													{{ $province->name }}
  												</option>
  												@empty

  												@endforelse
  											</select>
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="phy_city">City:</label>
  										<div class="col-sm-8">
  											<select name = "phy_city" id="phy_city" class = "form-control">
  												<option value="0"></option>
  											</select>
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="phy_zip">Zip Code:</label>
  										<div class="col-sm-8">
  											<input type="text" class="form-control" name = "phy_zip" id="phy_zip" placeholder="Enter Zip Code">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="same_billing_address">Same billing address:</label>
  										<div class="col-md-8">
  											<input type="checkbox" class = "checkbox same_billing_address">
  										</div>
  									</div>
  								</div>
  							</div>
  							<div id="billing_address" class="tab-pane fade in ">
  								<br />
  								<div class = "form-horizontal">
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="bill_address">Blk/ Lot/ Street:</label>
  										<div class="col-sm-8">
  											<input type="text" class="form-control" name = "bill_address" id="bill_address" placeholder="Enter  Address">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="bill_province">Province:</label>
  										<div class="col-sm-8">
  											<select name = "bill_province" id="bill_province"  class = "form-control">
  												<option value = '0'></option>
  												@forelse($provinces as $province)
  												<option value="{{ $province->id }}">
  													{{ $province->name }}
  												</option>
  												@empty

  												@endforelse
  											</select>
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="bill_city">City:</label>
  										<div class="col-sm-8">
  											<select name = "bill_city" id="bill_city" class = "form-control">
  												<option value="0"></option>
  											</select>
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-3" for="bill_zip">Zip Code:</label>
  										<div class="col-sm-8">
  											<input type="text" class="form-control" name = "bill_zip" id="bill_zip" placeholder="Enter Zip Code">
  										</div>
  									</div>
  								</div>
  							</div>
  							<div id="new_con" class="tab-pane fade in active">
  								<br />
  								<form class="form-horizontal" role="form">
  									{{ csrf_field() }}
  									<div class="form-group required">
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
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="pwd">Last Name:</label>
  										<div class="col-sm-6">
  											<input type="text" class="form-control" name = "lastName" id="lastName" placeholder="Enter Last Name">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="email">Email</label>
  										<div class="col-sm-6">
  											<input type="email" class="form-control" name = "email" id="email" placeholder="Enter Email Address">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="contactNumber">Contact Number:</label>
  										<div class="col-sm-6">
  											<input type="text" class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="companyName">Company Name:</label>
  										<div class="col-sm-6">
  											<input type="text" class="form-control" name = "companyName" id="companyName" placeholder="Enter Company Name">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="businessStyle">Business Style:</label>
  										<div class="col-sm-6">
  											<input type="text" class="form-control" name = "businessStyle" id="businessStyle" placeholder="Enter Business Style">
  										</div>
  									</div>
  									<div class="form-group required">
  										<label class="control-label col-sm-4" for="TIN">TIN:</label>
  										<div class="col-sm-6">
  											<input type="text" class="form-control" name = "TIN" id="TIN" placeholder="Enter TIN">
  										</div>
  									</div>

  								</form>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
  			<div class="modal-footer">
  				<button class = "btn btn-info btn-md save-consignee-information" id = "btnConsigneeSave" >Save Consignee</button>
  				<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
  			</div>
		  </div>
    </div>
  </div>
</section>

<!-- Add Location Modal -->
<section class="content">
  <div class="modal fade" id="LocationModal" role="dialog">
   <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">New Location</h4>
     </div>
     <div class="modal-body">
      <form role="form" method = "POST" id="commentForm" class = "form-horizontal">
       {{ csrf_field() }}
         <div class="form-group required">
          <label class = "control-label col-md-3">Name: </label>
            <div class = "col-md-9">
             <input type = "text" class = "form-control" name = "name" id = "name" minlength = "3"/>
            </div>
         </div>
         <div class="form-group required">
           <label class = "control-label col-md-3">Address: </label>
            <div class = "col-md-9">
             <textarea class = "form-control" id = "address" name = "address"></textarea>
            </div>
         </div>
         <div class="form-group required">
            <label class = "control-label col-md-3">Province: </label>
            <div class = "col-md-9">
               <select name = "loc_province" id="loc_province" class = "form-control">
                <option value = '0'></option>
                @forelse($provinces as $province)
                <option value="{{ $province->id }}" >
                 {{ $province->name }}
               </option>
               @empty

               @endforelse
               </select>
           </div>
        </div>
        <div class="form-group required">
          <label class = "control-label col-md-3">City: </label>
          <div class = "col-md-9">
           <select name = "loc_city" id="loc_city" class = "form-control">
            <option value="0"></option>
            </select>
          </div>
        </div>
        <div class="form-group required">
          <label class = "control-label col-md-3">ZIP: </label>
          <div class = "col-md-9">
           <input type = "text" class = "form-control" name = "zip" id = "zip" minlength = "3"/>
          </div>
        </div>
      </form>
     </div>
      <div class="modal-footer">
        <button type = "submit" class="btn btn-success btnSave"  >Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
  </div>
</section>

  <!-- Confirm Save -->
        <section class="content">
          <div class="modal fade" id="ProcessedByModal" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Processed By</h4>
                </div>
                <div class="modal-body">
                  <form role="form" method = "POST" id="commentForm" class = "form-horizontal">
                    {{ csrf_field() }}
                    <label class="control-label col-sm-4" for="noOfDeliveries" >Processed by:</label>
                    <div class="col-sm-6">
                      <select name = "processedBy" id = "processedBy" class = "form-control" required data-msg="Select a Processor">
                        <option value = "0"></option>
                        @forelse($employees as $employee)
                        <option value = "{{ $employee->id }}">
                          {{ $employee->lastName . ", " . $employee->firstName }}
                        </option>
                        @empty

                        @endforelse
                      </select>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type = "submit" class="btn btn-success" id = "brokerageBtn" >Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type = "submit" class="btn btn-success" id = "brokerageBtn" >Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</section>

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
<link href="/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script  type = "text/javascript" charset = "utf8" src="/js/select2/select2.full.js"></script>
<script src="/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">

	$('#collapse1').addClass('in');

	var data;
	var cs_id;
	var consigneeID = null;
	var selected_location = 0;
  var wodetail_row = "<tr>" + $('#wodescription_row').html() + "</tr>";
  var container_row = "<tr>" + $('#container_row').html() + "</tr>";

  var container_copy = "<div class='panel-group'>" + $('#container_copy').html() + "</div>";
  var container_ctr = 1;
  var container_array = [0];
  var selected_container = 0;
  var json;
  var results;
  var con_Number = [];
  var con_Volume = [];
  var con_ShippingLine = [];
  var con_PortOfCfsLocation = [];
  var con_ReturnTo = [];
  var con_ReturnAddress = [];
  var con_ReturnDate = [];
  var descrp_goods = [];
  var gross_weights = [];
	var lcl_types = [];

	$(document).ready(function(){



		$('#exitPrompt').on('click', function(e){
			$('#brokerage_warning').removeClass('in');
		});

		$('#consignee_id').select2();

		$('#expectedArrivalDate').datepicker({
		    onSelect: function(value, ui) {

		    },
		    minDate: 0,
		    changeMonth: true,
		    changeYear: true
		});

		$('#arrivalDateButton').click(function () {
		 $('#expectedArrivalDate').datepicker('show');
		 });


    $(document).on('click', '.pick_add_new_location', function(e){
      e.preventDefault();
    })

    $(document).on('click', '.ConfirmBut', function(e){
      e.preventDefault();
    })

		$(document).on('change', '#consignee_id', function(e){
			consigneeID = $('#consignee_id').val();
			if($('#consignee_id').val() != 0){
				$.ajax({
					type: 'GET',
					url: "{{ route('consignee.index')}}/" + $('#consignee_id').val() + "/getConsignee",
					data: {
						'_token' : $('input[name=_token]').val(),
					},
					success: function(data){
						if(typeof(data) == "object"){
							console.log(data);
							$('#_cfirstName').val(data[0].firstName);
							$('#_cmidddleName').val(data[0].middleName);
							$('#_clastName').val(data[0].lastName);
							$('#_ccontactNumber').val(data[0].contactNumber);
							$('#_cemail').val(data[0].email);
							$('#_ccompanyName').val(data[0].companyName);
							$('#_cbusinessStyle').val(data[0].businessStyle);
							$('#_cTIN').val(data[0].TIN);
						}
					},
					error: function(data) {
						if(data.status == 400){
							alert("Nothing found");
						}
					}
				})
			}
			else
			{
				$('#_cfirstName').val("");
				$('#_cmidddleName').val("");
				$('#_clastName').val("");
				$('#_ccontactNumber').val("");
				$('#_cemail').val("");
				$('#_ccompanyName').val("");
				$('#_cbusinessStyle').val("");
				$('#_cTIN').val("");
			}
		})

		$(document).on('click', '.add_new_consignee', function(e){
			e.preventDefault();
			$('#chModal').modal('show');
		})

		$(document).on('change', '#phy_province', function(e){

			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#phy_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){
						console.log(data);
						var new_rows = "<option value = '0'></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#phy_city').find('option').not(':first').remove();
						$('#phy_city').html(new_rows);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})

		$(document).on('change', '#bill_province', function(e){

			$.ajax({
				type: 'GET',
				url: "{{ route('get_prov_cities')}}/" + $('#bill_province').val(),
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){
					if(typeof(data) == "object"){
						console.log(data);
						var new_rows = "<option value = '0'></option>";
						for(var i = 0; i < data.length; i++){
							new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
						}
						$('#bill_city').find('option').not(':first').remove();
						$('#bill_city').html(new_rows);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		})

		$(document).on('change', '.same_billing_address', function(e){
			e.preventDefault();
			var checked = $('.same_billing_address').is(":checked");
			if(checked == true){
				$('#bill_address').attr('disabled', 'true');
				$('#bill_address').val("");
				$('#bill_zip').val("");
				$('#bill_zip').attr('disabled', 'true');
				$('#bill_city').attr('disabled', 'true');
				$('#bill_province').attr('disabled', 'true');
			}
			else{
				$('#bill_province').val("");
				$('#bill_city').val("");
				$('#bill_address').removeAttr('disabled');
				$('#bill_province').removeAttr('disabled');
				$('#bill_city').removeAttr('disabled');
				$('#bill_zip').removeAttr('disabled');
			}

		})

		$(document).on('click', '.new-consignee', function(e){
			e.preventDefault();
			$('#chModal').modal('show');

		})

		$(document).on('click', '.save-consignee-information', function(e){
			e.preventDefault();
			var checked = $('.same_billing_address').is(":checked");

			if(validateConsignee() == true){

				$.ajax({
					type: 'POST',
					url: '{{ route("consignee.index") }}',
					data: {
						'_token' : $('input[name=_token]').val(),
						'firstName' : $('#firstName').val(),
						'middleName' : $('#middleName').val(),
						'lastName' : $('#lastName').val(),
						'companyName' : $('#companyName').val(),
						'email' : $('#email').val(),
						'contactNumber' : $('#contactNumber').val(),
						'businessStyle' : $('#businessStyle').val(),
						'TIN' : $('#TIN').val(),

						'address' : $('#phy_address').val(),
						'city' : $('#phy_city option:selected').text(),
						'st_prov' : $('#phy_province option:selected').text(),
						'zip' : $('#phy_zip').val(),

						'b_address' : $('#bill_address').val(),
						'b_city' : $('#bill_city option:selected').text(),
						'b_st_prov' : $('#bill_province option:selected').text(),
						'b_zip' : $('#bill_zip').val(),

						'same_billing_address' : checked,



					},
					success: function (data) {
						console.log(data);
						if(typeof(data) == "object"){
							consigneeID = data.id;
							$('#chModal').modal('hide');
							$('#collapse_1').removeClass('in');
							$('#collapse_2').addClass('in');
							$('#_firstName').val($('#firstName').val() + " " + $('#middleName').val() + " " + $('#lastName').val());
							$('#_companyName').val($('#companyName').val());

							$('#_email').val($('#email').val());
							$('#_contactNumber').val($('#contactNumber').val());

							$('#firstName').val("");
							$('#middleName').val("");
							$('#lastName').val("");
							$('#companyName').val("");
							$('#email').val("");
							$('#address').val("");
							$('#contactNumber').val("");
							$('#TIN').val("");
							$('#businessStyle').val("");


							$('#_cfirstName').val(data.firstName);
							$('#_cmidddleName').val(data.middleName);
							$('#_clastName').val(data.lastName);
							$('#_ccontactNumber').val(data.contactNumber);
							$('#_cemail').val(data.email);
							$('#_ccompanyName').val(data.companyName);
							$('#_cbusinessStyle').val(data.businessStyle);
							$('#_cTIN').val(data.TIN);
						}
					}
				})
			}
		})

		function validateOrder()
		{
			error = "";
			if(consigneeID == null || consigneeID == 0){
				error += "No selected consignee";
				$('#consignee_id').css('border-color', 'red');
			}
			else{
				$('#consignee_id').css('border-color', 'green');
			}
			if($('#processedBy').val() == "0"){
				error += "No processedBy";
				$('#processedBy').css('border-color', 'red');
			}
			else{
				$('#processedBy').css('border-color', 'green');
			}
			if(error.length == 0){
				return true;
			}
			else{
				return false;
			}
		}



		function validateConsignee()
		{
			var error = "";
			if($('#firstName').val() === ""){
				$('#firstName').css('border-color', 'red');
				error += "First name is required. \n";
			}
			else
			{
				$('#firstName').css('border-color', 'green');
			}
			if($('#middleName').val() === ""){
				$('#middleName').css('border-color', 'green');
			}
			else
			{
				$('#middleName').css('border-color', 'green');
			}
			if($('#lastName').val() === ""){
				$('#lastName').css('border-color', 'red');
				error += "Last name is required.\n";
			}
			else
			{
				$('#lastName').css('border-color', 'green');
			}

			if($('#companyName').val() === ""){
				$('#companyName').css('border-color', 'red');
				error += "Company name is required.\n";
			}
			else
			{
				$('#companyName').css('border-color', 'green');
			}

			if($('#businessStyle').val() === ""){
				$('#businessStyle').css('border-color', 'red');
				error += "Business Style is required.\n";
			}
			else
			{
				$('#businessStyle').css('border-color', 'green');
			}

			if($('#TIN').val() === ""){
				$('#TIN').css('border-color', 'red');
				error += "TIN is required.\n";
			}
			else
			{
				$('#TIN').css('border-color', 'green');
			}
			if($('#email').val() === ""){
				$('#email').css('border-color', 'red');
				error += "Email is required.\n";
			}
			else
			{
				$('#email').css('border-color', 'green');
			}
			if($('#contactNumber').val() === ""){
				$('#contactNumber').css('border-color', 'red');
				error += "Contact Number is required.\n";
			}
			else
			{
				$('#contactNumber').css('border-color', 'green');
			}
			console.log(error);
			if(error.length == 0){

				return true;
			}
			else{
				return false;
			}

		}
	})

	$(document).on('change', '#deliver_id', function(e){
		deliver_id = $(this).val();
		selected_to = $(this).val();
		if(deliver_id != 0)
		{
			$.ajax({
				type: 'GET',
				url: '{{ route("location.index") }}/' + deliver_id + '/getLocation',
				data: {
					'_token' : $('input[name=_token]').val(),
				},
				success: function(data){

					if(typeof(data) == "object"){
						$('#_daddress').val(data[0].address);
						$('#_dcity').val(data[0].city_name);
						$('#_dprovince').val(data[0].province_name);
						$('#_dzip').val(data[0].zipCode);
					}
				},
				error: function(data) {
					if(data.status == 400){
						alert("Nothing found");
					}
				}
			})
		}
		else{
			$('#_daddress').val("");
			$('#_dcity').val("");
			$('#_dprovince').val("");
			$('#_dzip').val("");
		}
		if(selected_from != 0 && selected_to != 0){
			$.ajax({
				type: 'GET',
				url: '{{ route("get_area_rate") }}',
				data: {
					'area_from' : selected_from,
					'area_to' : selected_to,
				},
				success : function(data) {
					if(data.length == 0){
						$('#standard_rate').html('No set standard rate for <strong>' + $('#pickup_id :selected').text() + "</strong> to <strong>" + $('#deliver_id :selected').text() + "<strong>");
						$('#deliveryFee').val("0.00");
					}
					else{
						$('#standard_rate').html("<strong>" + $('#pickup_id :selected').text() + "</strong> to <strong>" + $('#deliver_id :selected').text() + "</strong> : <strong>Php " + data[0].amount + "</strong>");
						$('#deliveryFee').val(data[0].amount);
					}
				}
			})
		}
		if(selected_from == 0 || selected_to == 0)
		{
			$('#deliveryFee').val("0.00");
			$('#standard_rate').html("");
		};

	})

	$(document).on('change', '#loc_province', function(e){
		fill_cities(0);
	})

	$(document).on('click', '.btnSave', function(e){

		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: "{{ route('location.index')}}",
			data: {
				'_token' : $('input[name=_token]').val(),
				'name' : $('#name').val(),
				'address' : $('#address').val(),
				'cities_id' : $('#loc_city').val(),
				'zipCode' : $('#zip').val(),
			},
			success: function(data){

				if(selected_location == 0){
					$('#pickup_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
					$('#deliver_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
					$('#pickup_id').val(data.id);

					$('#_address').val($('#address').val());
					$('#_city').val($('#loc_city option:selected').text());
					$('#_province').val($('#loc_province option:selected').text().trim());
					$('#_zip').val($('#zip').val());

					$('#address').val("");
					$('#loc_city').val("0");
					$('#loc_province').val("0");
					$('#zip').val("");
					$('#LocationModal').modal('hide');
				}
				else{
					$('#pickup_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
					$('#deliver_id > option:last').after("<option value = " + data.id +">"+ data.name +"</option>");
					$('#deliver_id').val(data.id);
					$('#_daddress').val($('#address').val());
					$('#_dcity').val($('#loc_city option:selected').text());
					$('#_dprovince').val($('#loc_province option:selected').text().trim());
					$('#_dzip').val($('#zip').val());

					$('#address').val("");
					$('#loc_city').val("0");
					$('#loc_province').val("0");
					$('#zip').val("");
					$('#LocationModal').modal('hide');
				}

			$('#LocationModal').modal('hide');

			},
			error: function(data) {
				if(data.status == 400){
					alert("Nothing found");
				}
			}
		})
})
	function clear_location(){
		$('#address').val("");
		$('#loc_city').val("0");
		$('#loc_province').val("0");
		$('#zip').val("");
	}

	function fill_cities(num)
	{
		console.log(num);
		$.ajax({
			type: 'GET',
			url: "{{ route('get_prov_cities')}}/" + $('#loc_province').val(),
			data: {
				'_token' : $('input[name=_token]').val(),
			},
			success: function(data){
				if(typeof(data) == "object"){

					var new_rows = "<option value = '0'></option>";
					for(var i = 0; i < data.length; i++){
						new_rows += "<option value = '"+ data[i].id+"'>"+ data[i].name +"</option>";
					}
					$('#loc_city').find('option').not(':first').remove();
					$('#loc_city').html(new_rows);

					$('#loc_city').val(num);
				}
			},
			error: function(data) {
				if(data.status == 400){
					alert("Nothing found");
				}
			}
		})
	}

  // Container
  $(document).on('click', '.add-new-container', function(e){
    e.preventDefault();
    new_container = container_copy.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    new_container = new_container.replace('0_', container_ctr + "_");
    container_array.push(container_ctr);
    container_ctr++;
    $('#container_copy:last-child').append(new_container);
  })
  $(document).on('click', '.remove-container-row', function(e){
    e.preventDefault();
    var id = $(this).val();
    for(var i = 0; i < container_array.length; i ++){
      if(container_array[i] == id[0])
      {
        container_array.splice(i, 1);
      }
    }
    console.log(container_array);
    $('#' + $(this).val()).remove();

  })
  $(document).on('click', '.save-container-row', function(e){
    e.preventDefault();
    var id = $(this).closest("tr").find('.row_containerNumber').val() + '_table';
    if($('#' + id).length === 0){
      $('#cargo_delivery_details').append('<table class = "table-responsive table" id = "' + $(this).closest("tr").find('.row_containerNumber').val() + '_table"><thead><tr><td>Container Number: '+ $(this).closest("tr").find('.row_containerNumber').val() +'</tr></td><tr><td>Description of Goods</td><td>Gross Weight(kg)</td><td>Supplier/s</td><td>Action</td></tr></thead><tbody><tr id = "description_row"><td width="35%"><input type = "text" name = "'+ id +'_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "number" name = "'+ id +'_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "'+ id +'_supplier"  class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-primary add-container-detail" value = "'+  id + '">+</button><button class = "btn btn-md btn-danger remove-container-detail" value = "' + id +'">x</button></td></tr></tbody></table>');
    }
  })

  $(document).on('click', '.new-container-detail', function(e){
    e.preventDefault();
    var id = $(this).val();
    selected_container = id[0];
    if(validateCurrentContainerDetail() == true){

      console.log(id);
      var detail_row = '<tr id = "description_row"><td width="35%"><input type = "text" name =   "'+ id[0] + '_descriptionOfGoods" class = "form-control"/></td><td width="20%"><input type = "text" name = "'+ id[0] +'_grossWeight" class = "form-control"/></td><td width="30%"><input type = "text" name = "'+id[0] +'_supplier" class = "form-control" /></td><td width="15%"><button class = "btn btn-md btn-danger remove-container-detail" value = "'+ $(this).val() + '">x</button></td></tr>';
      $('#'+ id[0] + '_details' + ":last-child").append(detail_row);
    }

  })
  $(document).on('click', '.remove-container-detail', function(e){
    e.preventDefault();
    $(this).closest('tr').remove();
  })
  // Without Container ------------------------------------------------------------------------------------------------------------------------
  $(document).on('click', '.add-new-detail', function(e){
    e.preventDefault();
    if(validateDetail() === true){
      $('#detail_table:last-child').append(wodetail_row);
    }
  })
  $(document).on('click', '.remove-current-detail', function(e){
    e.preventDefault();
    if($('#detail_table > tbody > tr').length > 1){
      $(this).closest('tr').remove();
    }
    else{
      //Do nothing
    }
  })
  $(document).on('click', '.woadd-new-detail', function(e){
    e.preventDefault();

    if(validateDetail() === true){
      $('#wodetail_table:last').append(wodetail_row);
    }
  })
  $(document).on('click', '.woremove-current-detail', function(e){
    e.preventDefault();
    if($('#wodetail_table > tbody > tr').length > 1){
      $(this).closest('tr').remove();
    }
  })

  function validateCurrentContainerDetail()
  {
    error = "";
    con_descrp = document.getElementsByName(selected_container + '_descriptionOfGoods');
    con_gw = document.getElementsByName(selected_container + '_grossWeight');
    con_supp = document.getElementsByName(selected_container + '_supplier');
    for (var j = 0; j < con_descrp.length; j++) {
      if(con_descrp[j].value === "")
      {
        con_descrp[j].style.borderColor = "red";
        error += "Description is required";
      }
      else
      {
        con_descrp[j].style.borderColor = 'green';
      }
      if(con_gw[j].value === "")
      {
        error+= "Weight is required";
        con_gw[j].style.borderColor = 'red';
      }
      else
      {
        con_gw[j].style.borderColor = 'green';
      }
    }
    if(error.length == 0){
      return true;
    }
    else
    {
      return false;
    }

  }
  function validateContainerDetail(){
    error = "";
    json = [];
    var linkData;
    for (var i = 0; i < container_array.length; i++) {
      var child = [{ }];
      child[0]['container'] = [{
        containerNumber : con_Number[i],
        containerVolume : con_Volume[i],
        shippingLine : con_ShippingLine[i],
        portOfCfsLocation : con_PortOfCfsLocation[i],
        containerReturnTo : con_ReturnTo[i],
        containerReturnAddress : con_ReturnAddress[i],
        containerReturnDate : con_ReturnDate[i]
      }];
      child[0]['details'] = [];
      table_detail_row_count = $('#' + container_array[i] + "_details > tbody > tr").length;

      var name = container_array[i];


      con_descrp = document.getElementsByName(name + '_descriptionOfGoods');
      con_gw = document.getElementsByName(name + '_grossWeight');
      con_supp = document.getElementsByName(name + '_supplier');
      for (var j = 0; j < table_detail_row_count; j++) {
        if(con_descrp[j].value === "")
        {
          con_descrp[j].style.borderColor = "red";
          error += "Description is required";
        }
        else
        {
          con_descrp[j].style.borderColor = 'green';
        }
        if(con_gw[j].value === "")
        {
          error+= "Weight is required";
          con_gw[j].style.borderColor = 'red';
        }
        else
        {
          con_gw[j].style.borderColor = 'green';
        }
        child[0].details.push({
          descriptionOfGood : con_descrp[j].value,
          grossWeight : con_gw[j].value,
          supplier : con_supp[j].value
        });
      }
      json.push(child);
    }
    results = JSON.stringify(json);
    console.log(results);

    if(error.length == 0){
      return 0;
    }
    else
    {
      console.log(error);
      return false;
    }
  }


  function validateContainer(){
    con_Number = [];
    con_Volume = [];
    con_ReturnTo = [];
    con_ReturnAddress = [];
    con_ReturnDate = [];
    con_ShippingLine = [];
    con_PortOfCfsLocation = [];
    var error = "";
    con_number = document.getElementsByName("containerNumber");
    con_volume = document.getElementsByName("containerVolume");
    con_to = document.getElementsByName("containerReturnTo");
    con_address = document.getElementsByName("containerReturnAddress");
    con_date = document.getElementsByName("containerReturnDate");
    con_ship = document.getElementsByName('shippingLine');
    con_port = document.getElementsByName('portOfCfsLocation');
    for(var i = 0; i < con_number.length; i++)
    {
      if(con_number[i].value === ""){
        error += "Container number is required.";
        con_number[i].style.borderColor = 'red';
      }
      else{
        con_Number.push(con_number[i].value);
        con_number[i].style.borderColor = 'green';
      }
      if(con_volume[i].value === ""){
        error += "Container volume is required.";
        con_volume[i].style.borderColor = 'red';
      }
      else{
        con_Volume.push(con_volume[i].options[con_volume[i].selectedIndex].text);
        con_volume[i].style.borderColor = 'green';
      }
      if(con_to[i].value === ""){
        error += "Container return to is required.";
        con_to[i].style.borderColor = 'red';
      }
      else{
        con_ReturnTo.push(con_to[i].value);
        con_to[i].style.borderColor = 'green';
      }
      if(con_address[i].value === ""){
        error += "Container return address is required.";
        con_address[i].style.borderColor = 'red';
      }
      else{
        con_ReturnAddress.push(con_address[i].value);
        con_address[i].style.borderColor = 'green';
      }
      if(con_date[i].value === ""){
        error += "Container return date is required.";
        con_date[i].style.borderColor = 'red';
      }
      else{
        con_ReturnDate.push(con_date[i].value);
        con_date[i].style.borderColor = 'green';
      }
      if(con_port[i].value === ""){
        error += "Container port is required.";
        con_port[i].style.borderColor = 'red';
      }
      else{
        con_PortOfCfsLocation.push(con_port[i].value);
        con_port[i].style.borderColor = 'green';
      }
      if(con_ship[i].value === ""){
        error += "Container ship is required.";
        con_ship[i].style.borderColor = 'red';
      }
      else
      {
        con_ShippingLine.push(con_ship[i].value);
        con_ship[i].style.borderColor = 'green';
      }

    }
    console.log(error);
    if(error.length === 0){
      return true;
    }
    else{
      return false;
    }
  }
  function validateDetail(){
    descrp_goods = [];
    gross_weights = [];
    suppliers = [];
		lcl_types = [];
		var error = "";

    if($("#choices li.active").text() === "Without Container"){
      descrp = document.getElementsByName("wodescriptionOfGoods");
      gw = document.getElementsByName("wogrossWeight");
      supp = document.getElementsByName("wosupplier");
	 lcl = document.getElementsByName("wolclTypes");
		}
    for(var i = 0; i < descrp.length; i++){
      if(descrp[i].value === ""){
        error += "No description";
        descrp[i].style.borderColor = 'red';
      }
      else{
        descrp_goods.push(descrp[i].value);
        descrp[i].style.borderColor = 'green';
      }
      if(gw[i].value === ""){
        error += "No gross weight";
        gw[i].style.borderColor = 'red';
      }
      else{
        gross_weights.push(gw[i].value);
        gw[i].style.borderColor = 'green';
      }
      if(supp[i].value === ""){
        suppliers.push("");
      }
      else{
        suppliers.push(supp[i].value);
      }
			if(lcl[i].value === "")
			{
				lcl[i].style.borderColor = 'red';
				error += "No LCL Type"
			}
			else{
				lcl_types.push(lcl[i].value);
			}
    }
    if(error.length === 0){
      return true;
    }
    else{
      return false;
    }
  }


  $('#brokerageBtn').on('click', function(e){

		var loc = document.getElementById("pickup_id");
		var basis = document.getElementById("basis");
		var strloc = loc.options[loc.selectedIndex].value;
		var strbasis = basis.options[basis.selectedIndex].value;
		var withCOToggle;

		if(document.getElementById("withCO").checked == true)
		{
			withCOToggle = 1;
		}
		if(document.getElementById("withCO").checked == false)
		{
			withCOToggle = 0;
		}

        if($("#choices li.active").text() === "Without Container"){
          if(validateDetail() === true){
          console.log("without continer");

					console.log("basis: "+strbasis);
					console.log("cargoType: "+document.getElementById('cargoType').value,);
					console.log("withCO: "+withCOToggle);

          console.log("descrp_goods: "+descrp_goods);
          console.log("suppliers: "+suppliers);
					console.log("lcl_types: "+lcl_types);
					console.log("gross_weights: "+gross_weights);
          }
        }
        else {
          if(validateContainer() == true){
            console.log("with continer");

						console.log("basis: "+strbasis);
						console.log("cargoType: "+document.getElementById('cargoType').value,);
						console.log("withCO: "+withCOToggle);

            console.log('containerNumber: ' + con_Number);
            console.log('containerVolume: ' + con_Volume);
            console.log('containerReturnTo: ' + con_ReturnTo);
            console.log('containerReturnAddress: ' + con_ReturnAddress);
            console.log('containerReturnDate: ' + con_ReturnDate);
            console.log('shippingLine: ' + con_ShippingLine);
            console.log('portOfCfsLocation: ' + con_PortOfCfsLocation);
          console.log('container_data: ' + results);
        }
      }



      	if(Validations() == true)
    		{

      }
      if(Validations() == false){
        if($("#choices li.active").text() === "Without Container"){
          if(validateDetail() === true){

              $.ajax({
                type: 'POST',
                url: "{{ route('saveBrokerageOrder') }}",
                data: {
                  '_token' : $('input[name=_token]').val(),
                  'cs_id' : consigneeID,
                  'employee_id' : $('#processedBy').val(),
                  'location_id': strloc,
                  'shipper' : document.getElementById('shipper').value,
                  'companyName' : document.getElementById('freightNumber').value,
                  'freightType' : document.getElementById('FreightType').value,
                  'arrivalDate' : document.getElementById('expectedArrivalDate').value,
                  'freightNumber' : document.getElementById('freightNumber').value,
                  'weight' : document.getElementById('weight').value,
									'basis' : strbasis,
									'cargoType' : document.getElementById('cargoType').value,
									'withCO' : withCOToggle,
                  'descrp_goods' : descrp_goods,
									'lcl_types' : lcl_types,
                  'gross_weights' : gross_weights,
                  'suppliers' : suppliers,
                },
                success: function(data){
                  if(typeof(data) == "object"){
                    console.log(data);
                    $('#_cfirstName').val(data[0].firstName);
                    $('#_cmidddleName').val(data[0].middleName);
                    $('#_clastName').val(data[0].lastName);
                    $('#_ccontactNumber').val(data[0].contactNumber);
                    $('#_cemail').val(data[0].email);
                    $('#_ccompanyName').val(data[0].companyName);
                    $('#_cbusinessStyle').val(data[0].businessStyle);
                    $('#_cTIN').val(data[0].TIN);
                  }
                  window.location.replace('/brokerage/'+data+'/order');
                },
                error: function(data) {
                  if(data.status == 400){
                    alert("Nothing found");
                  }
                }


            })
          }
          }
        else {

            if(validateContainer() == true){
              validateContainerDetail();
              $.ajax({
                type: 'POST',
                url: "{{ route('saveBrokerageOrder') }}",
                data: {
                  '_token' : $('input[name=_token]').val(),
                  'cs_id' : consigneeID,
                  'employee_id' : $('#processedBy').val(),
                  'location_id': strloc,
                  'shipper' : document.getElementById('shipper').value,
                  'companyName' : document.getElementById('freightNumber').value,
                  'freightType' : document.getElementById('FreightType').value,
                  'arrivalDate' : document.getElementById('expectedArrivalDate').value,
                  'freightNumber' : document.getElementById('freightNumber').value,
                  'weight' : document.getElementById('weight').value,
									'basis' : strbasis,
									'cargoType' : document.getElementById('cargoType').value,
									'withCO' : withCOToggle,
                  'containerNumber' : con_Number,
  								'containerVolume' : con_Volume,
  								'containerReturnTo' : con_ReturnTo,
  								'containerReturnAddress' : con_ReturnAddress,
  								'containerReturnDate' : con_ReturnDate,
  								'shippingLine' : con_ShippingLine,
  								'portOfCfsLocation' : con_PortOfCfsLocation,
  								'container_data' : results,
                },
                success: function(data){
                  if(typeof(data) == "object"){
                    console.log(data);
                    $('#_cfirstName').val(data[0].firstName);
                    $('#_cmidddleName').val(data[0].middleName);
                    $('#_clastName').val(data[0].lastName);
                    $('#_ccontactNumber').val(data[0].contactNumber);
                    $('#_cemail').val(data[0].email);
                    $('#_ccompanyName').val(data[0].companyName);
                    $('#_cbusinessStyle').val(data[0].businessStyle);
                    $('#_cTIN').val(data[0].TIN);
                  }
                  window.location.replace('/brokerage/'+data+'/order');
                },
                error: function(data) {
                    if(data.status == 400){
                      alert("Nothing found");
                    }
                }
            })
          }
        }
      }
    });



  //containerNumber
  Inputmask("A{3} A{1} 9{6} 9{1}").mask($("input[name=containerNumber]"));

	function Validations(){

    resetMessages();
    var isError = false;
    if($('#expectedArrivalDate').valid() == false)
    {
      location.href = '#brokerageTitleHeader';
      $('#expectedArrivalDate').css('border-color', 'red');
      $('#brokerage_warning').addClass('in');
      $('#arrivalDateError').addClass('in');

        isError= true;
    }

		if($('#FreightType').valid() == false)
		{

				location.href = '#brokerageTitleHeader';
				$('#FreightType').css('border-color', 'red');
				$('#brokerage_warning').addClass('in');
				$('#freightTypeError').addClass('in');

        isError = true;
    }

		if($('#freightNumber').valid() == false)
		{

			location.href = '#brokerageTitleHeader';
			$('#freightNumber').css('border-color', 'red');
	  	$('#brokerage_warning').addClass('in');
			$('#BLError').addClass('in');

				isError = true;
		}

		var pickup = document.getElementById("pickup_id");

		if(pickup.options[pickup.selectedIndex].value == 0)
		{

			location.href = '#brokerageTitleHeader';
			$('#pickup_id').css('border-color', 'red');
			$('#brokerage_warning').addClass('in');
			$('#pickupError').addClass('in');

				isError = true;
		}

		if($('#shipper').valid() == false)
		{
			location.href = '#brokerageTitleHeader';
			$('#shipper').css('border-color', 'red');
			$('#brokerage_warning').addClass('in');
			$('#shipperError').addClass('in');

				isError = true;
		}

		if($('#weight').valid() == false)
		{

			location.href = '#brokerageTitleHeader';
			$('#weight').css('border-color', 'red');
			$('#brokerage_warning').addClass('in');
			$('#weightError').addClass('in');

				isError = true;
		}

		var pby = document.getElementById("processedBy");

		if(pby.options[pby.selectedIndex].value == 0)
		{
			location.href = '#brokerageTitleHeader';
			$('#processedBy').css('border-color', 'red');
			$('#brokerage_warning').addClass('in');
			$('#processedByError').addClass('in');

				isError = true;
		}

		return isError;

	}

	function resetMessages(){
    $('#arrivalDateError').removeClass('in');

    $('#freightTypeError').removeClass('in');

    $('#BLError').removeClass('in');

    $('#pickupError').removeClass('in');

		$('#shipperError').removeClass('in');
    $('#weightError').removeClass('in');

		$('#weight').valid();
    $('#processedByError').removeClass('in');

		$('#processedBy').valid();
  }

</script>
@endpush
