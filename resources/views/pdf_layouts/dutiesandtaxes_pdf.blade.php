<!DOCTYPE html>
<html>
<head>
  <!-- CSS goes in the document HEAD or added to your external stylesheet -->
  <style type="text/css">
  table.gridtable {
    float:left;
    width:75%;
 position:relative;
  	font-family: verdana,arial,sans-serif;
  	font-size:13px;
  	color:#333333;
  	border-width: 1px;
  	border-color: #666666;
  	border-collapse: collapse;
  }
  table.gridtable th {
  	border-width: 1px;
  	padding: 8px;
  	border-style: solid;
  	border-color: #666666;
  	background-color: #dedede;
  }
  table.gridtable td {
  	border-width: 1px;
  	padding: 8px;
  	border-style: solid;
  	border-color: #666666;
  	background-color: #ffffff;
  }

  table.gridtable2 {
    width: 21%;
 position:absolute;
 left: 800px;
 top: 321px;

    font-family: verdana,arial,sans-serif;
    font-size:11px;
    color:#333333;
    border-width: 1px;
    border-color: #666666;
    border-collapse: collapse;
  }
  table.gridtable2 th {

    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #666666;
    background-color: #dedede;

  }
  table.gridtable2 td {
    border-width: 1px;
  	padding: 8px;
  	border-style: solid;
  	border-color: #666666;
  	background-color: #ffffff;
  }

  tr.tre{
    background:#b3ffff;
  }

  tr.one{
      background:#ebebe0;
  }
  tr.two{
      background:##ffff99;
  }
}
.oddrowcolor{
	background-color:#d4e3e5;
}
.evenrowcolor{
	background-color:#c3dde0;
}
  </style>




</head>

<body>
  <div style="float: left;">
    <img src="{{ public_path() }}\images\pilotlogo.png"/>
  </div>
  <div style="margin-left: 200px;">
    <br />
    <small><strong style="text-align: center;">PILOT CARGO CHAIN SOLUTION INC.</strong></small>
    <br />
    <small><strong style="text-align: center;">Suite 318 Velco Center Building Port Area Manila</strong></small>
    <br />
    <small><strong style="text-align: center;">Tel. Nos. 523-0201, 495-0832</strong></small>
    <br />
    <small><strong style="text-align: center;">Fax: 523-0201</strong></small>
    <br />
    <small><strong style="text-align: center;">Email add: jay@pilotcargochain.com / jca_pilot@yahoo.com.ph</</strong></small>
  </div>
  <br />
  <br />

  <div style="text-align: center;">
    <small style="text-align: center;">Freight Forwarding, Customs Clearance (Air &amp; Sea), Project &amp; Heavy Equipment</small>
  </div>
  <hr />
  <h3><center>Customs Duty and Tax Declaration</center></h3>
    <table class="table table-responsive table-borderless" >
        <tr>
          <td class = "fit" style = "font-family: verdana,arial,sans-serif; font-size: 13px;" >
              <label class="control-label"  id = "consignee">  Consignee: @php echo $brokerage_header[0]->companyName @endphp</label>
          </td>
        </tr>
    </table>

    <table class="table table-responsive table-borderless" style = "width: 50%;">
        <tr style = "font-family: verdana,arial,sans-serif; font-size: 13px;">
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
        <tr style = "font-family: verdana,arial,sans-serif; font-size: 13px;">
          <td>
            <label class = "control-label" id = "arrivalDate"> Arrival: @php echo $brokerage_header[0]->expectedArrivalDate @endphp </label>
          </td>
          <td>
            <label class = "control-label" id = "port"> Port: @php echo $brokerage_header[0]->name @endphp  </label>
          </td>
          <td>
              <label class = "control-label" id = "exchangeRate">Exchange Rate: @php echo  number_format((float)$exchangeRate[0]->rate, 3, '.', '') @endphp </label>
          </td>
        </tr>
  </table>
<br />

      <table class = "gridtable"  id = "itemTable" >
        <tr>
          <td class = "fit"><h5><label>Item Name</label></h5></td>
          <td class = "fit"><h5><label>Value in USD</label></h5></td>
          <td class = "fit"><h5><label>Insurance</label></h5></td>
          <td class = "fit" ><h5><label>Freight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label></h5></td>
          <td class = "fit"><h5><label>Total Value</label></h5></td>
          <td class = "fit"><h5><label>Dutiable Value in Peso</label></h5></td>
          <td><h5><label>HS Code</label></h5></td>
          <td><h5><label>Rate of Duty</label></h5></td>
          <td class = "fit"><h5><label>Customs Duty</label></h5></td>
        </tr>

        @php
          $totalUSD = 0.00; $totalInsurance = 0.00; $totalFreight = 0.00; $totalValue = 0.00; $totalDutiableValue = 0.00; $totalCustomsDuty = 0.00;
        @endphp
        @forelse($dutiesandtaxes_details as $items)
        <tr>
            <td>
              {{ $items->descriptionOfGoods }}
            </td>
            <td>
             $  {{ number_format((float)$items->valueInUSD , 2, '.', ',') }}
            </td>
            <td>
             $ {{  number_format((float)$items->insurance, 2, '.', ',') }}
            </td>
            <td>
             $  {{ number_format((float)$items->freight, 2, '.', ',') }}
            </td>

            @php
              $total = $items->valueInUSD + $items->insurance + $items->freight;
              $totalUSD += $items->valueInUSD;
              $totalInsurance += $items->insurance;
              $totalFreight += $items->freight;
              $totalValue += $total;
            @endphp
            <td>
              $ {{ number_format((float)$total, 2, '.', ',') }}
            </td>
            @php
              $dutiableValue = $total * $exchangeRate[0]->rate;
              $totalDutiableValue += $dutiableValue;
            @endphp
            <td>
             Php  {{ number_format((float)$dutiableValue, 2, '.', ',') }}
            </td>
            <td>
              {{ $items->hsCode }}
            </td>
            <td>
              {{ $items->rateOfDuty }}
            </td>
            @php
              $RateOfDuty = number_format((float)$items->rateOfDuty, 2, '.', '')/100.0;
              $CustomsDuty = $dutiableValue * $RateOfDuty;
              $totalCustomsDuty += $CustomsDuty;
            @endphp
            <td>
              Php {{ number_format((float)$CustomsDuty, 2, '.', ',')}}
            </td>
        </tr>

        @empty
        @endforelse
        <tr class = "tre">
          <td>
            Total:
          </td>
          <td>
            $ {{ number_format((float)$totalUSD, 2, '.', ',') }}
          </td>
          <td>
             $ {{ number_format((float)$totalInsurance, 2, '.', ',') }}
          </td>
          <td>
             $ {{ number_format((float)$totalFreight, 2, '.', ',') }}
          </td>
          <td>
             $ {{ number_format((float)$totalValue, 2, '.', ',') }}
          </td>
          <td>
             Php {{ number_format((float)$totalDutiableValue, 2, '.', ',') }}
          </td>
          <td>
          </td>
          <td>
          </td>
          <td>
            Php {{ number_format((float)$totalCustomsDuty, 2, '.', ',') }}
        </tr>
      </table>


        <table class = "gridtable2"  >
          <tr class = "one" id = "DutiableValue">
            <td>Dutiable Value</td>
            <td>
              {{ number_format((float)$totalDutiableValue, 2, '.', ',') }}
            </td>
          </tr>
          <tr class = "one" id = "CustomsDuty">
            <td>Customs Duty</td>
            <td>
              {{ number_format((float)$totalCustomsDuty, 2, '.', ',') }}
           </td>
          </tr>


          <tr class = "one" id = "BrokerageFee">
            <td>Brokerage Fee</td>
            <td>
              {{ number_format((float)$dutiesandtaxes_header[0]->brokerageFee, 2, '.', ',') }}
            </td>
          </tr>

          <tr class = "one" id = "BankCharges">
            <td>Bank Charges</td>
            <td>
              {{ number_format((float)$dutiesandtaxes_header[0]->bankCharges, 2, '.', ',') }}
            </td>
          </tr>

          <tr class = "one" id = "Arrastre">
            <td>Arrastre</td>
            <td>
              {{ number_format((float)$dutiesandtaxes_header[0]->arrastre, 2, '.', ',') }}
            </td>
          </tr>

          <tr class = "one" id = "Wharfage">
            <td>Wharfage</td>
            <td>
              {{ number_format((float)$dutiesandtaxes_header[0]->wharfage, 2, '.', ',') }}
            </td>
          </tr>
          <tr class = "one" id = "CDSFee">
            <td>CDS</td>
            <td>
              {{ number_format((float)$cds_fee[0]->fee, 2, '.', ',') }}
            </td>



          @forelse($ipf_fee_details  as $ipf)
            @php
              $ipfAmmount;
              $minimum = $ipf->minimum;
              $maximum = $ipf->maximum;
              $amount = $ipf->amount;

              if($totalDutiableValue >= $minimum && $totalDutiableValue <= $maximum)
              {
                $ipfAmmount = $amount;
              }
              if($totalDutiableValue > $maximum)
              {
                $ipfAmmount = 1000.00;
              }
            @endphp
          @empty
          @endforelse


          </tr>
          <tr class = "one" id = "IPFFee">
            <td>IPF</td>
            <td> {{  number_format((float)$ipfAmmount, 2, '.', ',') }}</td>
          </tr>
          @php
            $totalLandedCost =$totalDutiableValue + $totalCustomsDuty + $dutiesandtaxes_header[0]->brokerageFee + $dutiesandtaxes_header[0]->bankCharges + $dutiesandtaxes_header[0]->arrastre + $dutiesandtaxes_header[0]->wharfage + $cds_fee[0]->fee + $ipfAmmount;
            $tax = $totalLandedCost * 0.12;
          @endphp
          <tr class = "two" id = "TotalLandedCost">
            <td>Total Landed Cost</td>
            <td>
              {{  number_format((float)$totalLandedCost, 2, '.', ',') }}</td>
            </td>
          </tr>
          <tr class = "two">
            <td>VAT Rate</td>
            <td>12(%)</td>
          </tr>

          <tr class = "two" id = "TaxInPeso">
            <td>TAX In Peso</td>
            <td>
              {{  number_format((float)$tax, 2, '.', ',') }}</td>
            </td>
          </tr>


        </table>








</body>

</html>
