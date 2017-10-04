@extends('layouts.app')
@section('content')
<div class = "panel-heading">
  <h2 id = "DutiesAndTaxesHeader">&nbsp;Brokerage / Create Duties And Taxes </h2>
  <hr />
</div>
<div class="panel-body">
  <div class = "collapse" id = "dutiesAndTaxes_warning">
    <div class="panel-body alert alert-danger">
        <div class = "col-md-12">
          <strong class = "col-md-10">Uh-oh.. We were unable to calculate your order because of some unprecdented events</strong>
          <button class = "btn btn-danger col-md-1 pull-right" id = "exitPrompt" onclick = "resetMessages();"><small>X</small></button>
          <div class = "col-md-12">

            <li class = "collapse" id = "arrastreError"> > <a href = "#DutiesAndTaxesHeader" style = "text-decoration: none; color: red;">Input amount for arrastre</a></li>
            <li class = "collapse" id = "wharfageError"> > <a href = "#DutiesAndTaxesHeader" style = "text-decoration: none; color: red;">Input amount for wharfage</a></li>
            <li class = "collapse" id = "tableError"> > <a href = "#DutiesAndTaxesHeader" style = "text-decoration: none; color: red;">Add at least one item </a></li>

          </div>
        </div>
    </div>
  </div>


  <div class = "tab-content">

          <div id = "dutiesandtaxes_details" class="tab-pane fade in active">
              <div class = "col-md-12">
                <div class = "col-md-12">
                  <div class = "col-md-6">
                <div class = "form-horizontal">
                  <form data-toggle = "validator">

                  <div class="form-group">
                    <div class = "col-md-12">
                      <label class="col-md-4 control-label">Exhange Rate*</label>
                        <div class="col-md-8">
                            <div class="input-group input-group-lg">

                              <input  type="text" class="form-control" name = "exchangeRate" id = "exchangeRate" readonly = "true" value = '@php echo number_format((float)$exchange_rate[$currentExchange_id-1]->rate, 3, '.', '') @endphp' style="text-align: right;">
                              <span class="input-group-addon">
                              <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="Current" data-off="Custom" data-onstyle="success"  id = "exchangeRate_toggle" style="text-align: right;">
                              </span>
                            </div>
                         </div>
                      </div>
                    </div>

                    <div class="form-group" id = "validateArrastre">
                        <div class = "col-md-12">
                          <label class="col-md-4 control-label">Arrastre*</label>
                            <div class="col-md-8">
                                <div class="input-group input-group-lg ">
                                  <span class="input-group-addon" id="cdsfeeadd">Php</span>
                                    <input  type="text" class=" form-control" name = "arrastre" id = "arrastre" readonly = "true" style="text-align: right;" required >
                                    <span class="input-group-addon">
                                      <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="Current" data-off="Custom" data-onstyle="success"  id = "arrastre_toggle" style="text-align: right;">
                                    </span>
                                </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class = "col-md-12">
                          <label class="col-md-4 control-label">Wharfage*</label>
                            <div class="col-md-8">
                              <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="cdsfeeadd">Php</span>
                                  <input  type="text" class="form-control" name = "wharfage" id = "wharfage" readonly = "true" style="text-align: right;" required>
                                  <span class="input-group-addon">
                                    <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="Current" data-off="Custom" data-onstyle="success"  id = "wharfage_toggle" style="text-align: right;">
                                  </span>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class = "col-md-12">
                         <label class="col-md-4 control-label">CDS Fee*</label>
                          <div class = "col-md-8">
                          <div class="input-group  input-group-lg">
                            <span class="input-group-addon" id="cdsfeeadd">Php</span>
                            <input  type="text" class="form-control" name = "CDSFee" id = "CDSFee" readonly = "true" value = "@php echo number_format((float)$cds_fee[$currentCds_id-1]->fee, 2, '.', '') @endphp" style="text-align: right;">
                            <span class="input-group-addon">
                              <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-on="Current" data-off="Custom" data-onstyle="success"  id = "cdsFee_toggle">
                            </span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class = "col-md-12">
                          <label class="col-md-4 control-label ">IPF Fee*</label>
                            <div class = "col-md-8">
                              <div class="input-group  input-group-lg">
                                @if($currentIpf_id != 0)
                                <input type="checkbox" checked data-toggle="toggle" data-size="normal" data-on="Current" data-off="Custom" data-onstyle="success"  id = "ipfFee_toggle" style="text-align: right;">
                                @else
                                <div > No Ipf Fee's found </div>
                                @endif
                              </div>
                          </div>
                        </div>
                      </div>


                      <input  type="hidden" class=" form-control" name = "wharfage" id = "bankCharges" style="text-align: right;">

                  </form>
                </div>
              </div>
              <div class = "col-md-6">
                <div class="tab-pane">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Cargo Information
                    </div>
                    <div class="panel-body">
                      <div class = "col-md-12">
                        @if($withContainer == true)
                        <table id = "container_table" class = "table table-responsive" style="width: 100%;">
                          <thead>
                            <tr>
                              <td style="width: 5%;">

                              </td>
                              <td style="width: 25%;">
                                Container Number
                              </td>
                              <td style="width: 20%;">
                                Volume
                              </td>

                              <td style="width: 20%;">
                                Container Return Date
                              </td>
                              <td style="width: 20%;">
                                Action
                              </td>

                            </tr>
                          </thead>
                          <tbody>
                            @php
                            $num = 1
                            @endphp

                            @forelse($brokerage_containers as $delivery_container)
                            <tr>
                              <td>
                                {{ $num++ }}
                                <input type = "hidden" class = "containerReturnDate" value= "{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}" />
                                <input type = "hidden" class = "containerID" value= "{{ $delivery_container->id }}" />
                                <input type = "hidden" class = "containerReturnAddress" value= "{{ $delivery_container->containerReturnAddress }}" />
                                <input type = "hidden" class = "shippingLine" value= "{{ $delivery_container->shippingLine }}" />
                                <input type = "hidden" class = "portOfCfsLocation" value= "{{ $delivery_container->portOfCfsLocation }}" />
                                <input type = "hidden" class = "containerReturnTo" value = "{{ $delivery_container->containerReturnTo }}" />
                                <input type = "hidden" class = "dateReturned"
                                value = "@if($delivery_container->dateReturned == null)
                                @else
                                {{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}
                                @endif"
                                />
                                <input type = "hidden" class = "remarks" value = "{{ $delivery_container->remarks }}" />
                              </td>
                              <td>
                                <span class = "containerNumber">{{ $delivery_container->containerNumber }}</span>
                              </td>
                              <td>
                                <span class = "containerVolume">{{ $delivery_container->containerVolume }}</span>
                              </td>

                              <td>
                                <span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}</span>
                              </td>
                              @if($delivery_container->dateReturned != null)
                              <td>
                                <span class = "containerReturnDate">{{ Carbon\Carbon::parse($delivery_container->dateReturned)->toFormattedDateString() }}</span>
                              </td>
                              @else
                              <td>
                                <button class = "btn btn-info" value = "{{$delivery_container->id}}" onclick = "viewContainerDetails({{$delivery_container->id}})">Select</button>
                              </td>
                              @endif

                            </tr>
                            @empty
                            <tr>
                              <td colspan="4">
                                <h5>No records found.</h5>
                              </td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>

                        <div class = "collapse" id = "container_details_panel" >

                            <table class = "table table-responsive" id = "container_details_table" style="width: 100%;">
                              <thead>
                                <tr>
                                  <td>
                                    Description of Goods
                                  </td>
                                  <td>
                                    Gross Weight(kg)
                                  </td>
                                  <td>
                                    Supplier/s
                                  </td>
                                  <td>
                                    Actions
                                  </td>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse($container_with_detail as $container)
                                    @forelse($container['details'] as $detail)
                                    <tr>
                                      <td>

                                      </td>
                                      <td>

                                      </td>
                                      <td>

                                      </td>
                                      <td>

                                      </td>
                                    </tr>
                                    @empty
                                    <tr>
                                      <td colspan="4">
                                        <h5 style="text-align: center;">No records found.</h5>
                                      </td>
                                    </tr>
                                    @endforelse
                                @empty
                                @endforelse
                              </tbody>
                            </table>


                        </div>
                        @endif

                        @if($withContainer == false)
                        <table id = "detail_table" class = "table table-responsive">
                          <thead>
                            <tr>

                              <td>
                                Description Of Good
                              </td>
                              <td>
                                LCL Type
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
                            @php
                            $num = 1;
                            @endphp
                            @forelse($brokerage_details as $delivery_detail)
                            <tr>

                              <td>
                                {{ $delivery_detail->descriptionOfGoods }}
                              </td>
                              <td>
                                {{ $delivery_detail->lcl_type }}
                              </td>
                              <td>
                                {{ $delivery_detail->grossWeight }}
                              </td>
                              <td>
                                {{ $delivery_detail->supplier }}
                              </td>
                              <td>
                                <button class = 'btn btn-danger btn-md ' onclick = 'addContainerItem()'>Add Item</button>
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="4">
                                <h5>No records found.</h5>
                              </td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>
                        @endif

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <br/>
              <div class="form-group">
                <div class = "panel panel-default table-responsive">
                  <table id = "itemTable" class = "table table-hover table-responsive">
                    <tr  class="info">
                      <td>Item Name</td>
                      <td>HS Code</td>
                      <td>Rate Of Duty</td>
                      <td>Value in USD</td>
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
            </div>
      </div>
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


    <div class = "collapse" id = "item_warning">
      <div class="panel-body alert alert-danger">
          <div class = "col-md-12">
            <strong class = "col-md-10">Woopsies...theres some unexpected conflicts while attempting to submit the data</strong>
            <button class = "btn btn-danger col-md-1 pull-right" id = "exitItemPrompt" onclick = "resetItemMessages();"><small>X</small></button>
            <div class = "col-md-12">

              <li class = "collapse" id = "itemNameError"> > <a style = "text-decoration: none; color: red;">Supply an item name</a></li>
              <li class = "collapse" id = "HSCodeError"> > <a  style = "text-decoration: none; color: red;">An HS Code for the corresponding item is needed</a></li>
              <li class = "collapse" id = "rateError"> > <a  style = "text-decoration: none; color: red;">Input the rate</a></li>
              <li class = "collapse" id = "valueError"> > <a style = "text-decoration: none; color: red;">Input the value</a></li>
              <li class = "collapse" id = "insuraceError"> > <a  style = "text-decoration: none; color: red;">Input the insurance</a></li>
              <li class = "collapse" id = "freightError"> > <a  style = "text-decoration: none; color: red;">Input the freight</a></li>

            </div>
          </div>
      </div>
    </div>

  <form class = "form-horizontal">
  <div class="form-group">
      <label class="col-md-3 control-label">Item Name</label>
        <div class="col-md-7">
              <input  type="text" class="form-control" id = "itemName" required>
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-3 control-label">HS Code</label>
        <div class="col-md-7">
              <input  type="text" class="form-control" id = "HSCode" required>
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-3 control-label">Rate Of Duty</label>
        <div class="col-md-7">
              <input  type="text" class="form-control" id = "RateOfDuty" required>
      </div>
  </div>

  <div class="form-group">
      <label class="col-md-3 control-label">Value</label>
    <div class = "col-md-7">
    <div class="input-group">
        <span class="input-group-addon" id="valuefeeadd">$</span>
        <input type="number" class="form-control money"  aria-describedby="valuefeeadd" id = "Value" required>
      </div>
    </div>
  </div>

  <div class="form-group">
      <label class="col-md-3 control-label">Freight</label>
    <div class = "col-md-7">
    <div class="input-group">
        <span class="input-group-addon" id="freightadd">$</span>
        <input type="number" class="form-control money"  aria-describedby="freightadd" id = "Freight" required>
      </div>
    </div>
  </div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-success" id = "addItem" >Add</button>
  <input type = "reset" class = "btn btn-danger btn-md" value = "Clear" />
  <button type="button" class="btn btn-default money" onclick="$('#ItemModal').modal('hide');">Close</button>
    </form>
</div>
</div>
</div>
</div>


<!-- Custom Exchange Rate-->
<div class="modal fade" id="ExchangeRateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" onclick="$('#ExchangeRateModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Select Custom Exchange Rate </h4>
</div>
<div class="modal-body">
  <table id = "exchangeRateTable" class = "table table-hover table-responsive">
    <tr  class="info">
      <td>Rate</td>
      <td>Date Effective</td>
      <td>Actions</td>
    </tr>
    @php
      $exchangeRate_ctr = 0;
    @endphp
    @forelse($exchange_rate as $exchange_rates)
    <tr>
      <td>
        {{ $exchange_rates->rate }}
      </td>
      <td>
        {{ date_format(date_create($exchange_rates->dateEffective), "Y-m-d")}}
      </td>
      <td>
        @php
          $exchangeRate_ctr++;
        @endphp
        <button type="button" class="btn btn-success" onclick = "$('#ExchangeRateModal').modal('hide');
        currentExchange_id = <?php echo $exchangeRate_ctr; ?>;

        if(currentExchange_id == <?php echo $currentExchange_id?>)
        {
          document.getElementById('exchangeRate').value =  {{ number_format((float)$exchange_rates->rate, 3, '.', '') }};
            $('#exchangeRate_toggle').bootstrapToggle('on')
        }
        else{
          document.getElementById('exchangeRate').value =  {{ number_format((float)$exchange_rates->rate, 3, '.', '') }};
        }"
        > Select </button>
      </td>
    </tr>
      @empty
      @endforelse
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" onclick="$('#ExchangeRateModal').modal('hide'); ">Close</button>
    </form>
</div>
</div>
</div>
</div>


<!-- Custom CDS Fee-->
<div class="modal fade" id="CdsFeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" onclick="$('#CdsFeeModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Select Custom CDS Fee </h4>
</div>
<div class="modal-body">
  <table id = "cdsTable" class = "table table-hover table-responsive">
    <tr  class="info">
      <td>Fee</td>
      <td>Date Effective</td>
      <td>Actions</td>
    </tr>
    @php
      $cdsFee_ctr = 0;
    @endphp
    @forelse($cds_fee as $cds_fees)
    <tr>

      <td>
        {{ $cds_fees->fee }}
      </td>
      <td>
        {{ date_format(date_create($cds_fees->dateEffective), "Y-m-d")}}
      </td>
      <td>
        @php
          $cdsFee_ctr++;
        @endphp
        <button type="button" class="btn btn-success" onclick = "$('#CdsFeeModal').modal('hide');
        currentCds_id = <?php echo $cdsFee_ctr; ?>;

        if(currentCds_id == <?php echo $currentCds_id?>)
        {
          $('#cdsFee_toggle').bootstrapToggle('on')
          document.getElementById('CDSFee').value =  '{{ number_format((float)$cds_fees->fee, 3, '.', '') }}';

        }
        else{
          document.getElementById('CDSFee').value =  '{{ number_format((float)$cds_fees->fee, 3, '.', '') }}';
        }"
        > Select </button>
      </td>
    </tr>
      @empty
      @endforelse
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" onclick="$('#CdsFeeModal').modal('hide'); ">Close</button>
    </form>
</div>
</div>
</div>
</div>

<!-- Custom IPF Fee-->
<div class="modal fade" id="IPFModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" onclick="$('#IPFModal').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Select Custom Import Processing Fee </h4>
</div>
<div class="modal-body">
  <table id = "cdsTable" class = "table table-hover table-responsive">
    <tr  class="info">
      <td>Minimum Dutiable Value</td>
      <td>Maximum Dutiable Value</td>
      <td>IPF Amount</td>
      <td>Date Effective</td>
      <td>Actions</td>
    </tr>
    @php
      $Ipf_ctr = 0;
    @endphp
    @forelse($ipf_fee_header as $ipf_fee_headers)
    <tr>
      <td>
        @forelse($ipf_fee_detail as $ipf_fee_details)
        @if($ipf_fee_details->ipf_headers_id == $ipf_fee_headers->id)
        {{
          $ipf_fee_details->minimum
        }}
        @endif
        </br>
        @empty
        @endforelse
      </td>

      <td>
        @forelse($ipf_fee_detail as $ipf_fee_details)
        @if($ipf_fee_details->ipf_headers_id == $ipf_fee_headers->id)
        {{
          $ipf_fee_details->maximum
        }}
        @endif
        </br>
        @empty
        @endforelse
      </td>

      <td>
        @forelse($ipf_fee_detail as $ipf_fee_details)
        @if($ipf_fee_details->ipf_headers_id == $ipf_fee_headers->id)
        {{
          $ipf_fee_details->amount
        }}
        @endif
        </br>
        @empty
        @endforelse
      </td>

      <td>
        {{ date_format(date_create($cds_fees->dateEffective), "Y-m-d")}}
      </td>
      <td>
        @php
          $Ipf_ctr++;
        @endphp
        <button type="button" class="btn btn-success" onclick = "$('#IPFModal').modal('hide');
        currentIpf_id = <?php echo $ipf_fee_headers->id  ?>;


        if(currentIpf_id == <?php echo $currentIpf_id;?>)
        {
          $('#ipfFee_toggle').bootstrapToggle('on')
        }
        else{

        }"
        > Select </button>
      </td>
    </tr>
      @empty
      <td> No IPF Fee's Found </td>
      @endforelse
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" onclick="$('#IPFModal').modal('hide'); ">Close</button>
    </form>
</div>
</div>
</div>
</div>

@endsection
@push('styles')
<link href="/css/bootstrap-toggle.min.css" rel="stylesheet">

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
<script src="/js/bootstrap-toggle.min.js"></script>
<script  type = "text/javascript">

var currentExchange_id = <?php echo $currentExchange_id; ?>;
var exchangeRate = <?php echo json_encode($exchange_rate); ?>;
var currentCds_id = <?php echo $currentCds_id; ?>;
var cdsFee = <?php echo json_encode($cds_fee); ?>;
var currentIpf_id = <?php echo $currentIpf_id; ?>;
var ipfFeeHeader = <?php echo json_encode($ipf_fee_header); ?>;
var ipfFeeDetail = <?php echo json_encode($ipf_fee_detail); ?>;
var selectedContainerId = "";
var temp_arrastre, temp_wharfage;

	$('#collapse1').addClass('in');

  $('#exchangeRate_toggle').change(function() {
			var sam = $(this).prop('checked');
			if(String(sam) == "false")
			{
				$('#ExchangeRateModal').modal('show');
			}

			if(String(sam) == "true")
			{
				var currentExchange_id = <?php echo $currentExchange_id; ?>;
				document.getElementById('exchangeRate').value =  '<?php echo number_format((float)$exchange_rate[$currentExchange_id-1]->rate, 3, '.', '') ?>';
			}
	  })

    $('#arrastre_toggle').change(function() {
  			var sam = $(this).prop('checked');


  			if(String(sam) == "false")
  			{
               temp_arrastre =  document.getElementById('arrastre').value;
  			       document.getElementById('arrastre').value = "";
               $('#arrastre').removeAttr('readonly');
  			}


  			if(String(sam) == "true")
  			{
          $('#arrastre').attr('readonly', 'true');

          @if($withContainer == true)
            if(selectedContainerId == "")
            {
              document.getElementById('arrastre').value = "";
            }
            if(selectedContainerId != "")
            {
              document.getElementById('arrastre').value = temp_arrastre;
            }
          @endif
          @if($withContainer == false)
              document.getElementById('arrastre').value = temp_arrastre;
          @endif
        }
  	  })

      $('#wharfage_toggle').change(function() {
          var sam = $(this).prop('checked');
          if(String(sam) == "false")
          {
                 temp_wharfage = document.getElementById('wharfage').value;
                 document.getElementById('wharfage').value = "";
                 $('#wharfage').removeAttr('readonly');
          }

          if(String(sam) == "true")
          {
             $('#wharfage').attr('readonly', 'true');
             @if($withContainer == true)
             if(selectedContainerId == "")
             {
               document.getElementById('wharfage').value = "";
             }
             if(selectedContainerId != "")
             {
               document.getElementById('wharfage').value = temp_wharfage;
             }
            @endif
            @if($withContainer == false)
                document.getElementById('wharfage').value = temp_wharfage;
            @endif
          }
        })


		$('#cdsFee_toggle').change(function() {
				var sam = $(this).prop('checked');
				if(String(sam) == "false")
				{
					$('#CdsFeeModal').modal('show');
				}

				if(String(sam) == "true")
				{
					var currentExchange_id = <?php echo $currentCds_id; ?>;
					document.getElementById('CDSFee').value =  '<?php echo number_format((float)$cds_fee[$currentCds_id-1]->fee, 3, '.', '') ?>';
				}
		  })


			$('#ipfFee_toggle').change(function() {
					var sam = $(this).prop('checked');
					if(String(sam) == "false")
					{
						$('#IPFModal').modal('show');
					}

					if(String(sam) == "true")
					{
						currentIpf_id = <?php echo $currentIpf_id; ?>;
					}
			  })

  $(document).ready(function(){

    $('#exitPrompt').on('click', function(e){
      $('#dutiesAndTaxes_warning').removeClass('in');
    });

    $('#exitItemPrompt').on('click', function(e){
      $('#item_warning').removeClass('in');
    });


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

    if(ItemValidations() == true)
    {

    }
    if(ItemValidations() == false){
      var table = document.getElementById('itemTable');
      var row = table.insertRow();
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
      var cell3 = row.insertCell(3);
      var cell4 = row.insertCell(4);
      var cell5 = row.insertCell(5);

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
      cell5.innerHTML = "<button class = 'btn btn-danger btn-md' onclick = 'RemoveRow(this)' >Delete</button>";

      $('#ItemModal').modal('hide');
    }


	});

	$('#generateDAT').on('click', function(e){

    alert(localStorage.getItem("BankCharges"));
    if(Validations() == true)
    {

    }
    if(Validations() == false)
    {
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
    var employees = <?php echo json_encode($employees); ?>;
    localStorage.setItem("Employees", JSON.stringify(employees));
    localStorage.setItem("addedItems", JSON.stringify(addedItems));
    localStorage.setItem("itemCtr", ctr);

    localStorage.setItem("arrastre",  document.getElementById('arrastre').value);
    localStorage.setItem("wharfage",  document.getElementById('wharfage').value);
    localStorage.setItem("shipper", '<?php echo $brokerage_header[0]->shipper ?>');
    localStorage.setItem("freightNumber", '<?php echo $brokerage_header[0]->freightBillNo?>');
    localStorage.setItem("arrivalDate",  '<?php echo $brokerage_header[0]->expectedArrivalDate?>');
    localStorage.setItem("weight", <?php echo $brokerage_header[0]->Weight?>);
    localStorage.setItem("port",  '<?php echo $brokerage_header[0]->location?>');
    localStorage.setItem("companyName",  '<?php echo $brokerage_header[0]->companyName?>');
    localStorage.setItem("freightType",  '<?php echo $brokerage_header[0]->freightType?>');
    localStorage.setItem("bankCharges", document.getElementById('bankCharges').value);
    localStorage.setItem('brokerage_id', <?php echo $brokerage_id ?>);

    localStorage.setItem('withCO', '<?php echo $brokerage_header[0]->withCO?>');
    localStorage.setItem('cargo_type', '<?php echo $brokerage_header[0]->cargo_type?>');
    localStorage.setItem('insurance_gc', <?php echo $utility_types[0]->insurance_gc ?>);
    localStorage.setItem('insurance_c', <?php echo $utility_types[0]->insurance_c ?>);
    localStorage.setItem('bank_charges', <?php echo $utility_types[0]->bank_charges ?>);
    localStorage.setItem('other_charges', <?php echo $utility_types[0]->other_charges ?>);

    localStorage.setItem("currentExchange_id", currentExchange_id);
    localStorage.setItem("exchangeRate",  document.getElementById('exchangeRate').value);
    localStorage.setItem("currentCds_id", currentCds_id);
    localStorage.setItem("CDSFee",  document.getElementById('CDSFee').value);
    localStorage.setItem("currentIpf_id", currentIpf_id);
    localStorage.setItem("ipfFeeHeader", JSON.stringify(ipfFeeHeader));
    localStorage.setItem("ipfFeeDetail", JSON.stringify(ipfFeeDetail));

    window.location.replace("/dutiesandtaxes");


    }


	});


	})

  //currency scripts
	$(document).ready(function () {
	    $("input[type=text].currenciesOnly").on('keydown', currenciesOnly)
	                             .on('blur', function () { $(this).formatCurrency(); });
	})

		if($('#businessStyle').val() === ""){
			$('#businessStyle').css('border-color', 'red');
			error += "Business Style is required.\n";
		}
		else
		{
			$('#businessStyle').css('border-color', 'green');
		}

var allowedSpecialCharKeyCodes = [46,8,37,39,35,36,9];
var numberKeyCodes = [44, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105];
var commaKeyCode = [188];
var decimalKeyCode = [190,110];

function numbersOnly(event) {
    var legalKeyCode =
        (!event.shiftKey && !event.ctrlKey && !event.altKey)
            &&
        (jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
            ||
        jQuery.inArray(event.keyCode, numberKeyCodes) >= 0);

    if (legalKeyCode === false)
        event.preventDefault();
}

function numbersAndCommasOnly(event) {
    var legalKeyCode =
        (!event.shiftKey && !event.ctrlKey && !event.altKey)
            &&
        (jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
            ||
        jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
            ||
        jQuery.inArray(event.keyCode, commaKeyCode) >= 0);

    if (legalKeyCode === false)
        event.preventDefault();
}

function decimalsOnly(event) {
    var legalKeyCode =
        (!event.shiftKey && !event.ctrlKey && !event.altKey)
            &&
        (jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
            ||
        jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
            ||
        jQuery.inArray(event.keyCode, commaKeyCode) >= 0
            ||
        jQuery.inArray(event.keyCode, decimalKeyCode) >= 0);

    if (legalKeyCode === false)
        event.preventDefault();
}

	function currenciesOnly(event) {
	    var legalKeyCode =
	        (!event.shiftKey && !event.ctrlKey && !event.altKey)
	            &&
	        (jQuery.inArray(event.keyCode, allowedSpecialCharKeyCodes) >= 0
	            ||
	        jQuery.inArray(event.keyCode, numberKeyCodes) >= 0
	            ||
	        jQuery.inArray(event.keyCode, commaKeyCode) >= 0
	            ||
	        jQuery.inArray(event.keyCode, decimalKeyCode) >= 0);

	    // Allow for $
	    if (!legalKeyCode && event.shiftKey && event.keyCode == 52)
	        legalKeyCode = true;

	    if (legalKeyCode === false)
	        event.preventDefault();
	}

  function Validations(){

		resetMessages();
		var isError = false;



    if($('#arrastre').valid() == false)
    {
      location.href = '#dutiesAndTaxesHeader';
      $('#arrastre').css('border-color', 'red');
      $('#dutiesAndTaxes_warning').addClass('in');
      $('#arrastreError').addClass('in');

        isError = true;
    }

    if($('#wharfage').valid() == false)
    {
      location.href = '#dutiesAndTaxesHeader';
      $('#wharfage').css('border-color', 'red');
      $('#dutiesAndTaxes_warning').addClass('in');
      $('#wharfageError').addClass('in');

        isError = true;
    }

    var table = document.getElementById('itemTable');
		if(table.rows.length == 2)
		{

			location.href = '#dutiesAndTaxesHeader';
		  $('#dutiesAndTaxes_warning').addClass('in');
			$('#tableError').addClass('in');

				isError = true;
		}

		return isError;

	}

	function resetMessages(){

		$('#arrastreError').removeClass('in');
    $('#wharfageError').removeClass('in');
	  $('#tableError').removeClass('in');

  }

  function ItemValidations(){

    resetMessages();
    var isError = false;

    if($('#itemName').valid() == false)
    {
      $('#itemName').css('border-color', 'red');
      $('#item_warning').addClass('in');
      $('#itemNameError').addClass('in');

        isError = true;
    }

    if($('#HSCode').valid() == false)
    {
      $('#HSCode').css('border-color', 'red');
      $('#item_warning').addClass('in');
      $('#HSCodeError').addClass('in');

        isError = true;
    }

    if($('#RateOfDuty').valid() == false)
    {
      $('#RateOfDuty').css('border-color', 'red');
      $('#item_warning').addClass('in');
      $('#rateError').addClass('in');

        isError = true;
    }

    if($('#Value').valid() == false)
    {
      $('#Value').css('border-color', 'red');
      $('#item_warning').addClass('in');
      $('#valueError').addClass('in');

        isError = true;
    }

    if($('#Freight').valid() == false)
    {
      $('#Freight').css('border-color', 'red');
      $('#item_warning').addClass('in');
      $('#freightError').addClass('in');

        isError = true;
    }


    return isError;
  }

  function resetItemMessages(){

		$('#itemNameError').removeClass('in');
    $('#HSCodeError').removeClass('in');
	  $('#rateError').removeClass('in');
    $('#valueError').removeClass('in');
    $('#freightError').removeClass('in');

  }

  function RemoveRow(row)
  {
    $(row).closest("tr").remove();
  }

  function viewContainerDetails(id)
  {
    var table = document.getElementById('container_table');
    var containers = [];
    var container_details = [];
    var containerized_arrastre = [];
    var containerized_wharfage = [];
    var ctr = 1;


    @if($withContainer == true)
        @forelse($brokerage_containers as $delivery_container)
            containers[0] = '{{ $delivery_container->id }}'
            containers[1] = '{{ $delivery_container->containerNumber }}';
            containers[2] = '{{ $delivery_container->containerVolume }}';
            containers[3] = '{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}';


            if(containers[0] == id)
            {
              var tableRows = table.getElementsByTagName('tr');
              var rowCount = tableRows.length;

              for (var x=rowCount-1; x>0; x--) {
                table.deleteRow(x);
              }

              var row = table.insertRow();
              var cell0 = row.insertCell(0);
              var cell1 = row.insertCell(1);
              var cell2 = row.insertCell(2);
              var cell3 = row.insertCell(3);
              var cell4 = row.insertCell(4);

              cell0.innerHTML = '';
              cell1.innerHTML = '{{ $delivery_container->containerNumber }}';
              cell2.innerHTML = '{{ $delivery_container->containerVolume }}';
              cell3.innerHTML = '{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}';
              cell4.innerHTML = "<button class = 'btn btn-danger btn-md' onclick = 'resetContainerTable()'>Deselect</button>";

              selectedContainerId = '{{ $delivery_container->id }}';

             @forelse($containerized_arrastre_header as $cont_arrastre_head)

                @forelse($containerized_arrastre_detail as $cont_arrastre_det)

                  containerized_arrastre[0] = '{{$cont_arrastre_det->containerVolume}}';
                  containerized_arrastre[1] = '{{$cont_arrastre_det->amount}}';

                  if(containerized_arrastre[0] == containers[2])
                  {
                    document.getElementById('arrastre').value = '{{$cont_arrastre_det->amount}}';

                  }
                @empty
                @endforelse

              @empty
              @endforelse

              @forelse($containerized_wharfage_header as $cont_wharfage_head)

                @forelse($containerized_wharfage_detail as $cont_wharfage_det)

                  containerized_wharfage[0] = '{{$cont_wharfage_det->containerVolume}}';
                  containerized_wharfage[1] = '{{$cont_wharfage_det->amount}}';

                  if(containerized_wharfage[0] == containers[2])
                  {
                    document.getElementById('wharfage').value =  '{{$cont_wharfage_det->amount}}' ;

                  }
                @empty
                @endforelse

              @empty
              @endforelse



              @forelse($container_with_detail as $container)
                var table1 = document.getElementById('container_details_table');
                var tableRows = table1.getElementsByTagName('tr');
                var rowCount = tableRows.length;

                for (var x=rowCount-1; x>0; x--) {
                  table1.deleteRow(x);
                }
                    @forelse($container['details'] as $detail)
                      container_details[0] = '{{ $container['container']->containerNumber }}'
                      container_details[1] = '{{ $detail->descriptionOfGoods }}';
                      container_details[2] = '{{ $detail->grossWeight }}';
                      container_details[3] = '{{ $detail->supplier }}';

                      if(container_details[0] == containers[1])
                      {

                          alert('{{ $detail->descriptionOfGoods }}');

                          var row = table1.insertRow();
                          var cell0 = row.insertCell(0);
                          var cell1 = row.insertCell(1);
                          var cell2 = row.insertCell(2);
                          var cell3 = row.insertCell(3);

                          cell0.innerHTML = '{{ $detail->descriptionOfGoods }}';
                          cell1.innerHTML = '{{ $detail->grossWeight }}';
                          cell2.innerHTML = '{{ $detail->supplier }}';
                          cell3.innerHTML = "<button class = 'btn btn-danger btn-md ' onclick = 'addContainerItem()'>Add Item</button>";
                      }
                    @empty
                    @endforelse

              @empty
              @endforelse
            }
        @empty

        @endforelse
    @endif
    $('#container_details_panel').addClass('in');

  }

  function resetContainerTable()
  {
    var table = document.getElementById('container_table');
    var num = 1;
    var tableRows = table.getElementsByTagName('tr');
    var rowCount = tableRows.length;

    for (var x=rowCount-1; x>0; x--) {
      table.deleteRow(x);
    }
    @if($withContainer == true)
        @forelse($brokerage_containers as $delivery_container)

              var row = table.insertRow();

              var cell0 = row.insertCell(0);
              var cell1 = row.insertCell(1);
              var cell2 = row.insertCell(2);
              var cell3 = row.insertCell(3);
              var cell4 = row.insertCell(4);

              cell0.innerHTML = num;
              cell1.innerHTML = '{{ $delivery_container->containerNumber }}';
              cell2.innerHTML = '{{ $delivery_container->containerVolume }}';
              cell3.innerHTML = '{{ Carbon\Carbon::parse($delivery_container->containerReturnDate)->toFormattedDateString() }}';
              cell4.innerHTML = "<button class = 'btn btn-info btn-md' onclick = 'viewContainerDetails({{$delivery_container->id}})' >Select</button>";
              num++;
        @empty

        @endforelse
    @endif
    selectedContainerId = '';

    document.getElementById('arrastre').value = "";
    document.getElementById('wharfage').value = "";
    $('#container_details_panel').removeClass('in');
  }

  function addContainerItem()
  {
      $('#ItemModal').modal('show');
  }


  function resetContainerDetails()
  {

  }

  function setArrastreWharfage()
  {
    @if($withContainer == true)

     @if($delivery_container->containerVolume == 20)
      document.getElementById('arrastre').value = "3727.00";
      document.getElementById('wharfage').value =  "519.00";
     @endif
     @if($delivery_container->containerVolume == 40)
      document.getElementById('arrastre').value = "8551.00";
      document.getElementById('wharfage').value =  "779.00";
     @endif
     @if($delivery_container->containerVolume == 45)
      document.getElementById('arrastre').value = "3727.00";
      document.getElementById('wharfage').value =  "916.00";
     @endif
    @endif
    @if($withContainer == false)

    document.getElementById('arrastre').value = "149.00";

    document.getElementById('wharfage').value =  "519.00";
    @endif
  }


  window.onload = function(){
    @if($withContainer == false)


      var arrastre_total = 0.00;
      var wharfage_total = 0.00;

      @forelse($lcl_arrastre_header as $lcl_arrastre_hed)

        @forelse($lcl_arrastre_detail as $lcl_arrastre_det)

          @if($brokerage_header[0]->basis == $lcl_arrastre_det->basis_name)

            @forelse($brokerage_details as $brokerage_detail)
              @if($lcl_arrastre_det->lcl_type == $brokerage_detail->lcl_type)

                arrastre_total += parseFloat({{$lcl_arrastre_det->amount}});

              @else
              @endif
            @empty
            @endforelse
          @else

          @endif
      @empty
      @endforelse


      @empty
      @endforelse

      document.getElementById('arrastre').value = arrastre_total.toFixed(2);

      @forelse($lcl_wharfage_header as $lcl_wharfage_hed)

        @forelse($lcl_wharfage_detail as $lcl_wharfage_det)


            @if($brokerage_header[0]->basis == $lcl_wharfage_det->basis_name)
                wharfage_total += parseFloat({{$lcl_wharfage_det->amount}});
            @else

          @endif
      @empty
      @endforelse


      @empty
      @endforelse

      document.getElementById('wharfage').value = wharfage_total.toFixed(2);

    @endif

    @if($brokerage_header[0]->withCO == 1)
      document.getElementById('bankCharges').value =  "519.00";
    @endif
    @if($brokerage_header[0]->withCO == 0)
      document.getElementById('bankCharges').value =  "0.00";
    @endif
  }
</script>
@endpush
