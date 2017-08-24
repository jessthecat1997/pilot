	@extends('layouts.app')

	@section('content')
	<div class = "row">
			<div class = "panel default-panel">
				<div class = "panel-heading">
					<h3><img src="/images/bar.png"> Brokerage | Duties And Taxes</h3>
					<hr />


	  <div class = "panel-body form-horizontal">

			<table class="table table-responsive table-borderless" >

					<tr>
						<td class = "fit" >
								<label class="control-label"  id = "consignee">  </label>
						</td>
					</tr>
			</table>
			<table class="table table-responsive table-borderless" >

					<tr>
						<td>
							<label class = "control-label" id = "shipper">  </label>
						</td>
						<td>
							<label class = "control-label" id = "blNo">  </label>
						</td>
						<td>
								<label class = "control-label" id = "weight">  </label>
						</td>
					</tr>
					<tr>
						<td>
							<label class = "control-label" id = "arrivalDate">  </label>
						</td>
						<td>
							<label class = "control-label" id = "port">  </label>
						</td>
						<td>
								<label class = "control-label" id = "exchangeRate">  </label>
						</td>
					</tr>


			</table>




	    <div>
	      <div class = "col-md-9">
					<div class = "table-responsive">
	      <table class = "table table-bordered table-hover item-table" style="width:100%" id = "itemTable">
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
	      </table>
			</div>

			<form role = "form" method = "POST">
					{{ csrf_field() }}
	      <button type="button" class="btn btn-primary" id = "btnSave">
	        Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>

	      </button>
			</form>



	    </div>

	    <div class = "col-md-3">
	      <table class = "table table-condensed table-responsive">

					<tr class = "active" id = "DutiableValue">
						<td>Dutiable Value</td>

					</tr>
	        <tr class = "active" id = "CustomsDuty">
	          <td>Customs Duty</td>
	        </tr>

	        <tr class = "active" id = "BrokerageFee">
	          <td>Brokerage Fee</td>
	        </tr>

					<tr class = "active" id = "BankCharges">
						<td>Bank Charges</td>

					</tr>

	        <tr class = "active" id = "Arrastre">
	          <td>Arrastre</td>

	        </tr>

	        <tr class = "active" id = "Wharfage">
	          <td>Wharfage</td>
	        </tr>

	        <tr class = "active" id = "CDSFee">
	          <td>CDS</td>


	        </tr>
	        <tr class = "active" id = "IPFFee">
	          <td>IPF</td>

	        </tr>

	        <tr class = "warning" id = "TotalLandedCost">
	          <td>Total Landed Cost</td>
	        </tr>

	        <tr class = "warning">
	          <td>VAT Rate</td>
						<td>12(%)</td>
	        </tr>

	        <tr class = "warning" id = "TaxInPeso">
	          <td>TAX In Peso</td>
	        </tr>

	        <table class = "table table-condensed">
	          <tr>
	            <td>Summary of Duties and taxes</td>
	          </tr>
	          <tr class = "info" id = "SummCustomsDuty">
	            <td>Customs Duty </td>

	          </tr>


	          <tr class = "info" id = "SummaryVAT">
	            <td>VAT</td>

	          </tr>
	          <tr class = "info" id = "SummIPF">
	            <td>IPF</td>

	          </tr>
	        </table>
	      </table>
	      <table class = "table table-bordered table-condensed">
	        <tr class = "info" id = "SubTotal">
	            <td>SUB-TOTAL</td>

	        </tr>

	        <tr class = "info" id = "GrandTotal">
	            <td>GRAND TOTAL</td>

	        </tr>
	      </table>
	    </div>


	  </div>
	  </div>
	</div>
	</div>

	@endsection

	@push('styles')
	<style>
	.table-borderless > tbody > tr > td,
	.table-borderless > tbody > tr > th,
	.table-borderless > tfoot > tr > td,
	.table-borderless > tfoot > tr > th,
	.table-borderless > thead > tr > td,
	.table-borderless > thead > tr > th {
	    border: none;
	}

	.table td.fit,
	.table th.fit {
	    white-space: nowrap;
	    width: 1%;
	}
	</style>
	@endpush

	@push('scripts')
	<script type="text/javascript">
		$('#collapse1').addClass('in');


		window.onload = function(){
			document.getElementById('consignee').innerHTML = "Consignee: "+localStorage.getItem("companyName");
			document.getElementById('shipper').innerHTML = "Shipper: "+localStorage.getItem("shipper");
			document.getElementById('blNo').innerHTML = "BL/AWL No.: "+localStorage.getItem("freightNumber");
			document.getElementById('weight').innerHTML = "Weight: "+localStorage.getItem("weight") + "(kgs.)";
			document.getElementById('arrivalDate').innerHTML = "Arrival: "+localStorage.getItem("arrivalDate");
			document.getElementById('port').innerHTML = "Port: "+localStorage.getItem("port");
			document.getElementById('exchangeRate').innerHTML = "Exchange Rate: "+localStorage.getItem("exchangeRate");

			var storedItems = JSON.parse(localStorage.getItem("addedItems"));

			localStorage.getItem("tblRowLength");
			var tblRowLength = localStorage.getItem("tblRowLength")-2;
			var ExchangeRate = localStorage.getItem("exchangeRate");


			var currentExchange_id = localStorage.getItem("currentExchange_id");
			var currentCds_id = localStorage.getItem("currentCds_id");
			var currentIpf_id = localStorage.getItem("currentIpf_id");
			var ipfFeeHeader = JSON.parse(localStorage.getItem("ipfFeeHeader"));
			var ipfFeeDetail = JSON.parse(localStorage.getItem("ipfFeeDetail"));
			var ipfFee;

			var table = document.getElementById('itemTable');
	    var ctr = 7;

			var StoredItemName = new Array();
			var StoredHSCode = new Array();
			var StoredRateOfDuty = new Array();
			var StoredValue = new Array();
			var StoredInsurance = new Array();
			var StoredFreight = new Array();
			var StoredTotal = new Array();
			var StoredDutiableValue = new Array();
			var StoredCustomsDuty = new Array();

			var Value, Insurance, Freight, Total, DutiableValue, CustomsDuty;
			var TotalValue = 0, TotalInsurance = 0, TotalFreight = 0, _Total = 0, TotalDutiableValue = 0, TotalCustomsDuty = 0;
			var StrTotalValue, StrTotalInsurance, StrTotalFreight, StrTotal, StrTotalDutiableValue, StrTotalCustomsDuty;

			for(var r = 0, n = tblRowLength; r < n; r++)
			{
				var row = table.insertRow();
				var cell0 = row.insertCell(0);
				var cell1 = row.insertCell(1);
				var cell2 = row.insertCell(2);
				var cell3 = row.insertCell(3);
				var cell4 = row.insertCell(4);
				var cell5 = row.insertCell(5);
				var cell6 = row.insertCell(6);
				var cell7 = row.insertCell(7);
				var cell8 = row.insertCell(8);

				// 0 item Name
				StoredItemName[r] = storedItems[ctr];
				cell0.innerHTML =storedItems[ctr];
				ctr++;

				// 1 hs code
				StoredHSCode[r] = storedItems[ctr];
				cell6.innerHTML = storedItems[ctr];
				ctr++;

				// 2 rate of duty
				StoredRateOfDuty[r] = storedItems[ctr];
				RateOfDuty = storedItems[ctr];
				cell7.innerHTML =storedItems[ctr];
				ctr++;

				// 3  value
				StoredValue[r] = storedItems[ctr];
				Value = storedItems[ctr];
				ctr++;

				// 5 insurance
				StoredInsurance[r] = storedItems[ctr];
				Insurance = storedItems[ctr];
				cell2.innerHTML =storedItems[ctr];
				ctr++;

				// 4 freight
				StoredFreight[r] = storedItems[ctr];
				Freight = storedItems[ctr];
				cell3.innerHTML =storedItems[ctr];
				ctr+=2;

				Total = +parseFloat(Value).toFixed(2) + +parseFloat(Freight).toFixed(2) + +parseFloat(Insurance).toFixed(2)
				StoredTotal[r] = Total;

				DutiableValue = +Total * +parseFloat(ExchangeRate).toFixed(3);
				StoredDutiableValue[r] = DutiableValue;

				RateOfDuty = parseFloat(RateOfDuty) / 100.0;

				CustomsDuty = DutiableValue * RateOfDuty;
				StoredCustomsDuty[r] = CustomsDuty;

				cell1.innerHTML = "$ " + Value.replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
				cell2.innerHTML = "$ " + Insurance.replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
				cell3.innerHTML = "$ " + Freight.replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

				cell4.innerHTML = "$ " + Total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');;
				cell5.innerHTML = "Php " + DutiableValue.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
				cell8.innerHTML = "Php " + CustomsDuty.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

					TotalValue += +parseFloat(StoredValue[r]).toFixed(2);
					TotalInsurance += +parseFloat(StoredInsurance[r]).toFixed(2);
					TotalFreight += +parseFloat(StoredFreight[r]).toFixed(2);
					_Total += +parseFloat(StoredTotal[r]).toFixed(2);
					TotalDutiableValue += +parseFloat(StoredDutiableValue[r]).toFixed(2);
					TotalCustomsDuty += +parseFloat(StoredCustomsDuty[r]).toFixed(2);

					StrTotalValue = TotalValue.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					StrTotalInsurance = TotalInsurance.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					StrTotalFreight = TotalFreight.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					StrTotal = _Total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					StrTotalDutiableValue = TotalDutiableValue.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
					StrTotalCustomsDuty = TotalCustomsDuty.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
			}


			var newRow = $("<tr class = 'info table-borderless'>");
      var cols = "";

			cols += '<td><label class = "control-label">Total: </label></td>';
			cols += '<td> $ ' + StrTotalValue + '</td>';
			cols += '<td> $ ' + StrTotalInsurance + '</td>';
			cols += '<td> $ ' + StrTotalFreight + '</td>';
			cols += '<td> $ ' + StrTotal + '</td>';
			cols += '<td> Php '  + StrTotalDutiableValue + '</td>';
			cols += '<td>  </td>';
			cols += '<td>  </td>';
			cols += '<td> Php ' + StrTotalCustomsDuty + '</td></tr>';

			newRow.append(cols);
			$("table.item-table").append(newRow);


			var BrokerageFee, TotalLandedCost, TotalVat, GrandTotal;
			var StrTotalLandedCost, StrTotalVat, StrGrandTotal;

			var row = document.getElementById("DutiableValue");
    	var x = row.insertCell(1);
    	x.innerHTML = StrTotalDutiableValue;

			row = document.getElementById("CustomsDuty");
		  x = row.insertCell(1);
		 	x.innerHTML = StrTotalCustomsDuty;

			row = document.getElementById("Arrastre");
			x = row.insertCell(1);
			x.innerHTML = localStorage.getItem("arrastre");

			row = document.getElementById("Wharfage");
			x = row.insertCell(1);
			x.innerHTML = localStorage.getItem("wharfage");


			if(localStorage.getItem("BankCharges") == "" || localStorage.getItem("BankCharges") == null)
			{
				localStorage.setItem("BankCharges", "0.00");
			}
			row = document.getElementById("BankCharges");
			x = row.insertCell(1);
			x.innerHTML = localStorage.getItem("BankCharges");

			row = document.getElementById("CDSFee");
			x = row.insertCell(1);
			x.innerHTML = localStorage.getItem("CDSFee");



			//set IPF Fee
			var minimum, maximum, amount;
			for(var x = 0, n = ipfFeeDetail.length; x < n; x++)
			{
				if(ipfFeeDetail[x].ipf_headers_id == currentIpf_id)
				{
					minimum = ipfFeeDetail[x].minimum;
					maximum = ipfFeeDetail[x].maximum;
					amount = ipfFeeDetail[x].amount;

					if(TotalDutiableValue >= minimum && TotalDutiableValue <= maximum)
					{
						row = document.getElementById("IPFFee");
						x = row.insertCell(1);
						x.innerHTML = amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');;
						localStorage.setItem("IpfFee", amount);
					}
					if(TotalDutiableValue > maximum)
					{
						row = document.getElementById("IPFFee");
						x = row.insertCell(1);
						x.innerHTML = "1,000.00";
						localStorage.setItem("IpfFee", 1000.00);
					}

				}
			}

			//set Brokerage Fee
			if(TotalDutiableValue < 10000)
			{
				BrokerageFee = 1300.00;
				row = document.getElementById("BrokerageFee");
			  x = row.insertCell(1);
			 	x.innerHTML = "1,300.00";
			}

			if(TotalDutiableValue > 10000 && TotalDutiableValue < 20000)
			{
				BrokerageFee = 2000.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "2,000.00";
			}

			if(TotalDutiableValue > 20000 && TotalDutiableValue < 30000)
			{
				BrokerageFee = 2700.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "2,700.00";
			}

			if(TotalDutiableValue > 30000 && TotalDutiableValue < 40000)
			{
				BrokerageFee = 3300.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "3,300.00";
			}

			if(TotalDutiableValue > 40000 && TotalDutiableValue < 50000)
			{
				BrokerageFee = 3600.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "3,600.00";
			}

			if(TotalDutiableValue > 50000 && TotalDutiableValue < 60000)
			{
				BrokerageFee = 4000.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "4,000.00";
			}

			if(TotalDutiableValue > 60000 && TotalDutiableValue < 100000)
			{
				BrokerageFee = 4700.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "4,700.00";
			}

			if(TotalDutiableValue > 100000 && TotalDutiableValue < 200000)
			{
				BrokerageFee = 5300.00;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = "5,300.00";
			}

			if(TotalDutiableValue > 200000	)
			{
				BrokerageFee = (TotalDutiableValue - 200000) * 0.00125 + 5300;
				row = document.getElementById("BrokerageFee");
				x = row.insertCell(1);
				x.innerHTML = BrokerageFee.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
			}



			TotalLandedCost = +parseFloat(TotalDutiableValue).toFixed(2) + +parseFloat(TotalCustomsDuty).toFixed(2) + +parseFloat(BrokerageFee).toFixed(2) + +parseFloat(3043.00).toFixed(2) + +parseFloat(519.35).toFixed(2) + +parseFloat(265.00).toFixed(2) + +parseFloat(1000.00).toFixed(2);
			StrTotalLandedCost = parseFloat(TotalLandedCost).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

			TotalVat = +parseFloat(TotalLandedCost).toFixed(2) * parseFloat(0.12).toFixed(2);
			StrTotalVat = parseFloat(TotalVat).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

			row = document.getElementById("TotalLandedCost");
			x = row.insertCell(1);
			x.innerHTML = StrTotalLandedCost;

			row = document.getElementById("TaxInPeso");
			x = row.insertCell(1);
			x.innerHTML = StrTotalVat;

			row = document.getElementById("SummCustomsDuty");
			x = row.insertCell(1);
			x.innerHTML = StrTotalCustomsDuty;

			row = document.getElementById("SummIPF");
			x = row.insertCell(1);
			x.innerHTML = parseFloat(localStorage.getItem("IpfFee")).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');


			row = document.getElementById("SummaryVAT");
			x = row.insertCell(1);
			x.innerHTML = StrTotalVat;

			GrandTotal =  +parseFloat(TotalCustomsDuty).toFixed(2) + +parseFloat(TotalVat).toFixed(2) + +parseFloat(localStorage.getItem("IpfFee")).toFixed(2);
			StrGrandTotal = parseFloat(GrandTotal).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

			row = document.getElementById("GrandTotal");
			x = row.insertCell(1);
			x.innerHTML = StrGrandTotal;

			localStorage.setItem("jsonItemName", JSON.stringify(StoredItemName));
			localStorage.setItem("jsonHSCode",	JSON.stringify(StoredHSCode));
			localStorage.setItem("jsonRateOfDuty",	JSON.stringify(StoredRateOfDuty));
			localStorage.setItem("jsonValue",	JSON.stringify(StoredValue));
			localStorage.setItem("jsonFreight",	JSON.stringify(StoredFreight));
			localStorage.setItem("jsonInsurance",	JSON.stringify(StoredInsurance));
			localStorage.setItem("brokerageFee", BrokerageFee);
		}

		var CompanyName = localStorage.getItem("companyName");
		var ExchangeRateId = localStorage.getItem("currentExchange_id");
		var CDSId = localStorage.getItem("currentCds_id");
		var IPFId = localStorage.getItem("currentIpf_id");
		var Arrastre =  localStorage.getItem("arrastre");
		var Wharfage = localStorage.getItem("wharfage")
		var BankCharges = localStorage.getItem("BankCharges")
		var tblRowLength = localStorage.getItem("tblRowLength")-2;
		var cs_id = localStorage.getItem("cs_id");
		var shipper = localStorage.getItem("shipper");
		var arrivalDate = localStorage.getItem("arrivalDate");
		var freightNumber = localStorage.getItem("freightNumber");
		var Weight = localStorage.getItem("weight");
		var Port = localStorage.getItem("port");
		var FreightType = localStorage.getItem("freightType");
		var BrokerageFee = localStorage.getItem("brokerageFee");

		var jsonItemName = localStorage.getItem("jsonItemName");
		var jsonHSCode = localStorage.getItem("jsonHSCode");
		var jsonRateOfDuty = localStorage.getItem("jsonRateOfDuty");
		var jsonValue = localStorage.getItem("jsonValue");
		var jsonFreight = localStorage.getItem("jsonFreight");
		var jsonInsurance = localStorage.getItem("jsonInsurance");

		$('#btnSave').on('click', function(e){


			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '/storedutiesandtaxes',
				data: {
					'_token' : $('input[name=_token]').val(),
					'shipper' : shipper,
					'companyName' : CompanyName,
					'freightType' : FreightType,
					'exchangeRateId' : ExchangeRateId,
					'brokerageFee' : BrokerageFee,
					'ExchangeRateId' : ExchangeRateId,
					'CDSId' : CDSId,
					'IPFId': IPFId,
					'arrastre' : Arrastre,
					'wharfage' : Wharfage,
					'bankCharges' : BankCharges,
					'arrivalDate' : arrivalDate,
					'arrivalArea' : Port,
					'freightNumber' : freightNumber,
					'weight' : Weight,
					'cs_id' : cs_id,
					'tblRowLength' : tblRowLength,
					StoredItemName : jsonItemName,
					StoredHSCode : jsonHSCode,
					StoredRateOfDuty : jsonRateOfDuty,
					StoredValue : jsonValue,
					StoredFreight : jsonFreight,
					StoredInsurance : jsonInsurance,
				},
				success: function (data) {

					window.location.replace("brokerage/"+data+"/view");
				}
			})

		});



	  </script>
	@endpush
