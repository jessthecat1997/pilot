@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Import Processing Fee</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#ipfModal" style = 'width: 100%;'>New Import Processing Fee Range</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel-default panel">
			<div class = "panel-body">
				<table class = "table-responsive table  table-striped table-bordered" style="width: 100%;" id = "ipf_table">
					<thead>
						<tr>
							<td>
								Date Effective
							</td>
							<td>
								Dutiable Value Minimum
							</td>
							<td>
								Dutiable Value Maximum
							</td>
							<td>
								Import Processing Fee Amount
							</td>
							<td>
								Actions
							</td>
						</tr>
					</thead>
					<tbody>
						@forelse($ipfs as $ipf)
						<tr>
							<td>
								{{ Carbon\Carbon::parse($ipf->dateEffective)->format("F d, Y") }}
							</td>
							<td>
								{{ $ipf->minimum}}
							</td>
							<td>
								{{ $ipf->maximum}}
							</td>
							<td>
								{{ $ipf->amount}}
							</td>
							<td>
								<button value = "{{ $ipf->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button>
								<button value = "{{ $ipf->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
								<input type = "hidden" class = "date_effective" value = "{{$ipf->dateEffective}}">

							</td>
						</tr>
						@empty
						@endforelse

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<form role="form" method = "POST" class="commentForm">
		<div class="modal fade" id="ipfModal" role="dialog">
			<div class="form-group">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Import Processing Fee Range</h4>
						</div>
						<div class="modal-body ">
							<div class="form-group required">
								<label class="control-label " for="dateEffective">Date Effective:</label>
								<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date" data-rule-required="true">
							</div>
						</form>
						<br />
						<div class = "collapse" id = "ipf_table_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one import processing fee rate.
							</div>
						</div>
						<div class = "collapse" id = "ipf_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the range.
							</div>
						</div>
						<div class = "panel panel-default">
							<div  style="overflow-x: auto;">
								<div class = "panel-default">
									{{ csrf_field() }}
									<form id = "ipf_form" class = "commentForm">
										<table class="table responsive table-hover" width="100%" id= "ipf_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
											<thead>
												<tr>
													<td width="20%">
														<div class="form-group required">
															<label class = "control-label"><strong>Minimum Dutiable Value</strong></label>
														</div>
													</td>
													<td width="20%">
														<div class="form-group required">
															<label class = "control-label"><strong>Maximum Dutiable Value</strong></label>
														</div>
													</td>

													<td width="20%">
														<div class="form-group required">
															<label class = "control-label"><strong>Import Processing Amount</strong></label>
														</div>
													</td>
													<td width="10%" style="text-align: center;">
														<strong>Action</strong>
													</td>
												</tr>
											</thead>
											<tr id = "ipf-row">
												<td>

													<div class = "form-group input-group" >
														<span class = "input-group-addon">$</span>
														<input type = "text" class = "form-control ipf_minimum_valid money"
														value ="0.00" name = "minimum" id = "minimum"  data-rule-required="true" readonly="true"  style="text-align: right" />
													</div>

												</td>
												<td>
													<div class = "form-group input-group">
														<span class = "input-group-addon">$</span>
														<input type = "text" class = "form-control  ipf_maximum_valid money"
														value ="0.00" name = "maximum" id = "maximum"  data-rule-required="true" style="text-align: right;" />
													</div>
												</td>

												<td>
													<div class = "form-group input-group " >
														<span class = "input-group-addon">Php</span>
														<input type = "text" class = "form-control amount_valid money"
														value ="0.00" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/>
													</div>

												</td>
												<td style="text-align: center;">
													<button class = "btn btn-danger btn-md delete-ipf-row">x</button>
												</td>
											</tr>
										</table>
										<div class = "form-group" style = "margin-left:10px">
											<button    class = "btn btn-primary btn-md new-ipf-row pull-left">New Range</button>
											<br /><br/>
											
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button id = "btnSave" type = "submit" class="btn btn-success finalize-ipf">Save</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br/>
	</div>
</section>
<section class="content">
	<form role = "form" method = "POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<div class="modal fade" id="confirm-delete" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Deactivate record
					</div>
					<div class="modal-body">
						Confirm Deactivating
					</div>
					<div class="modal-footer">

						<button class = "btn btn-danger	" id = "btnDelete" >Deactivate</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<div class="modal fade" id="confirm-activate" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Activate record
			</div>
			<div class="modal-body">
				Confirm Activating
			</div>
			<div class="modal-footer">
				<button class = "btn btn-success" id = "btnActivate" >Activate</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

			</div>
		</div>
	</div>
</div>
</div>
@endsection
@push('styles')
<style>
.class-ipf-fee
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
@push('scripts')
<script type="text/javascript">
	$('#brokeragecollapse').addClass('in');
	$('#collapse2').addClass('in');
	var minimum_id = [];
	var maximum_id = [];
	var amount_value = [];
	var minimum_id_descrp = [];
	var maximum_id_descrp = [];
	var amount_value_descrp = [];
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	var data, tblLength;
	var ipf_id;
	var jsonMinimum, jsonMaximum, jsonAmount;
	$(document).ready(function(){
		var ipf_row = "<tr>" + $('#ipf-row').html() + "</tr>";
		
		var ipftable = $('#ipf_table').DataTable({
			"dom": '<"toolbar">frtip',
			processing: false,
			serverSide: false,
			deferRender: true,
			bSort: false,
			columns: [
			{ data: 'dateEffective' },
			{ data: 'minimum',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'maximum',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'amount',
			"render": function(data, type, row){
				return data.split("\n").join("<br/>");}
			},
			{ data: 'action', orderable: false, searchable: false }
			],	
		});


		$("div.toolbar").html('<div class = "col-md-3"><input type = "checkbox" class = "check_deac"/>   Show Deactivated</div>');
		$('.check_deac').on('change', function(e)
		{
			e.preventDefault();
			if($(this).is(':checked')){
				ipftable.ajax.url( '{{ route("ipf.data") }}/1').load();
			}
			else{
				ipftable.ajax.url( '{{ route("ipf.data") }}').load();
			}
		})

		$("#commentForm").validate({
			rules:
			{
				dateEffective:
				{
					required: true,
					date: true,
				},


			},
			onkeyup: false,
		});
		$(document).on('click', '.new', function(e){
			e.preventDefault();
	
			$('.modal-title').text('New Import Processing Fee Range');

			$('#dateEffective').val(today);
			$('#ipfModal').modal('show');

			$("ipf_parent_table > tbody").html("");
			$('#ipf_parent_table > tbody').html(ipf_row);
			$('#minimum').val("0.00");
			$('#maximum').val("0.00");
			$('#amount').val("0.00");

			$('.money').inputmask("numeric", {
				radixPoint: ".",
				groupSeparator: ",",
				digits: 2,
				autoGroup: true,
				rightAlign: true,
				removeMaskOnSubmit:true,
			});

		});
		$(document).on('click', '.edit',function(e){
			resetErrors();
			$('.modal-title').text('Update Import Processing Fee Range');
			ipf_id = $(this).val();
			data = ipftable.row($(this).parents()).data();
			$('#dateEffective').val($(this).closest('tr').find('.date_effective').val());
			$('#ipfModal').modal('show');

			$.ajax({
				type: 'GET',
				url:  '{{ route("ipf_maintain_data") }}',
				data: {
					'_token' : $('input[name=_token').val(),
					'ipf_id' : $(this).val(),
				},
				success: function (data)
				{
					var rows = "";
					for(var i = 0; i < data.length; i++){
						rows += '<tr id = "ipf-row"><td><div class = "form-group input-group" ><span class = "input-group-addon">$</span><input type = "text" class = "form-control money ipf_minimum_valid" value ="' + numberWithCommas(data[i].minimum) + '" name = "minimum" id = "minimum"  data-rule-required="true" readonly="true"  style="text-align: right" /></div></td><td><div class = "form-group input-group"><span class = "input-group-addon">$</span><input type = "text" class = "form-control  money ipf_maximum_valid" value ="'+ numberWithCommas(data[i].maximum) + '" name = "maximum" id = "maximum"  data-rule-required="true" style="text-align: right;" /></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control money amount_valid" value ="'+ numberWithCommas( data[i].amount) +'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td><td style="text-align: center;"><button class = "btn btn-danger btn-md delete-ipf-row">x</button></td></tr>';
					}
					$('#ipf_parent_table > tbody').html("");
					$('#ipf_parent_table > tbody').append(rows);

				}

			})

			$('.money').inputmask("numeric", {
				radixPoint: ".",
				groupSeparator: ",",
				digits: 2,
				autoGroup: true,
				rightAlign: true,
				removeMaskOnSubmit:true,
			});
		});
		$(document).on('click', '.deactivate', function(e){
			ipf_id = $(this).val();
			data = ipftable.row($(this).parents()).data();
			$('#confirm-delete').modal('show');
		});
		$(document).on('click', '.delete-ipf-row', function(e){
			e.preventDefault();
			if($('#ipf_parent_table > tbody > tr').length == 1){

				var obj = $(this).closest('tr');
				$(obj).nextAll().each(function(){
					$(this).remove();
				})
				obj.remove();
				$('#ipf_table_warning').addClass('fade in');

			}
			else{
				var obj = $(this).closest('tr');
				$(obj).nextAll('tr').each(function(){
					$(this).remove();
				})
				obj.remove();
				$('#bf_table_warning').removeClass('fade in');

			}
		})


		$(document).on('click', '.activate', function(e){
			ipf_id = $(this).val();
			data = ipftable.row($(this).parents()).data();
			$('#confirm-activate').modal('show');
		});
		$('#btnActivate').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'PUT',
				url:  '/utilities/ipf_fee_reactivate/' + ipf_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					ipftable.ajax.url( '{{ route("ipf.data") }}/1' ).load();
					$('#confirm-activate').modal('hide');

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 2000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr["success"]("Record activated successfully")
				}
			})
		});
		$(document).on('click', '.new-ipf-row', function(e){
			e.preventDefault();
			$('#ipf_table_warning').removeClass('fade in');
			if(validateIpfRows() === true){
				$('input[name=maximum]').each(function(){
					$(this).attr("readonly", "true");

				});
				$('#ipf_parent_table').append(ipf_row);

				$('.money').inputmask("numeric", {
					radixPoint: ".",
					groupSeparator: ",",
					digits: 2,
					autoGroup: true,
					rightAlign: true,
					removeMaskOnSubmit:true,
				});

				$(this).closest('tr').find('.ipf_minimum_valid').attr('readonly', true);

				for(var i = 0; i <= minimum.length; i++){
					minimum[i+1].value = (parseFloat("" +$(maximum[i]).inputmask('unmaskedvalue')) + 0.01).toFixed(2);
				}
			}
		})
		
		$(document).on('change', '.ipf_minimum_valid', function(e){
			$(".ipf_minimum_valid").each(function(){
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
					$('#ipf_warning').removeClass('in');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})
		$(document).on('keypress', '.amount_valid', function(e){
			$(".amount_valid").each(function(){
				try{
					var amount = parseFloat($(this).val());
				}
				catch(err){
				}
				if(typeof(amount) === "string"){
				}
				else{
				}
				if($(this).val() != ""){
					$(this).css('border-color', 'green');
					$('#ipf_warning').removeClass('in');
				}
				else{
					$(this).css('border-color', 'red');
				}
			});
		})
		$('#btnDelete').on('click', function(e){
			e.preventDefault();
			$.ajax({
				type: 'DELETE',
				url:  '/admin/ipf_fee/' + ipf_id,
				data: {
					'_token' : $('input[name=_token').val()
				},
				success: function (data)
				{
					ipftable.ajax.url( '{{ route("ipf.data") }}' ).load();
					$('#confirm-delete').modal('hide');
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"rtl": false,
						"positionClass": "toast-bottom-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": 300,
						"hideDuration": 1000,
						"timeOut": 2000,
						"extendedTimeOut": 1000,
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr["success"]("Record deactivated successfully")
				}
			})
		});
		$(document).on('click', '.finalize-ipf', function(e){
			e.preventDefault();
			if(finalvalidateIpfRows() === true){

				var title = $('.modal-title').text();
				if(title == "New Import Processing Fee Range")
				{
					jsonMinimum = JSON.stringify(minimum_id);
					jsonMaximum = JSON.stringify(maximum_id);
					jsonAmount = JSON.stringify(amount_value);

					minimum_unmask = [];
					$.ajax({
						type: 'POST',
						url:  '/admin/ipf_fee',
						data: {
							'_token' : $('input[name=_token]').val(),
							'dateEffective' : $('#dateEffective').val(),
							'minimum' : jsonMinimum,
							'maximum' : jsonMaximum,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
						},
						success: function (data){
							if(typeof(data) === "object"){
								ipftable.ajax.url( '{{ route("ipf.data") }}' ).load();
								$('#ipfModal').modal('hide');
								$('.modal-title').text('New Import Processing Fee Range');
								$('#minimum').val("0.00");
								$('#maximum').val("0.00");
								$('#amount').val("0.00");
								$('#dateEffective').val("");
								toastr.options = {
									"closeButton": false,
									"debug": false,
									"newestOnTop": false,
									"progressBar": false,
									"rtl": false,
									"positionClass": "toast-bottom-right",
									"preventDuplicates": false,
									"onclick": null,
									"showDuration": 300,
									"hideDuration": 1000,
									"timeOut": 2000,
									"extendedTimeOut": 1000,
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}
								toastr["success"]("Record addded successfully")

							}else{

								e.preventDefault();
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
								});

							}
						}
					})
				}else{



					jsonMinimum = JSON.stringify(minimum_id);
					jsonMaximum = JSON.stringify(maximum_id);
					jsonAmount = JSON.stringify(amount_value);


					$.ajax({
						type: 'PUT',
						url:  '/admin/ipf_fee/'+ ipf_id,
						data: {
							'_token' : $('input[name=_token]').val(),
							'ipf_head_id':ipf_id,
							'dateEffective' : $('#dateEffective').val(),
							'minimum' : jsonMinimum,
							'maximum' : jsonMaximum,
							'amount' : jsonAmount,
							'tblLength' : tblLength,
						},
						success: function (data){
							if(typeof(data) === "object"){
								ipftable.ajax.url( '{{ route("ipf.data") }}' ).load();
								$('#ipfModal').modal('hide');
								$('.modal-title').text('New Import Processing Fee Range');
								$('#minimum').val("0.00");
								$('#maximum').val("0.00");
								$('#amount').val("0.00");
								$('#dateEffective').val("");
								toastr.options = {
									"closeButton": false,
									"debug": false,
									"newestOnTop": false,
									"progressBar": false,
									"rtl": false,
									"positionClass": "toast-bottom-right",
									"preventDuplicates": false,
									"onclick": null,
									"showDuration": 300,
									"hideDuration": 1000,
									"timeOut": 2000,
									"extendedTimeOut": 1000,
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}
								toastr["success"]("Record updated successfully")

							}else{

								e.preventDefault();
								resetErrors();
								var invdata = JSON.parse(data);
								$.each(invdata, function(i, v) {
									console.log(i + " => " + v);
									var msg = '<label class="error" for="'+i+'">'+v+'</label>';
									$('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
								});

							}
						}
					})


				}
			}
		});
	});
function validateIpfRows()
{
	minimum_id = [];
	maximum_id = [];
	amount_value = [];
	minimum_id_descrp = [];
	maximum_id_descrp = [];
	amount_value_descrp = [];
	range_pairs = [];
	dateEffective = document.getElementsByName('dateEffective');
	minimum =  document.getElementsByName('minimum');
	maximum =   document.getElementsByName('maximum');
	amount =  document.getElementsByName('amount');
	error = "";

	var min, max,amt;
	if(dateEffective === ""){
		dateEffective.style.borderColor = 'red';
		error += "Date Effective Required.";
	}
	for(var i = 0; i < minimum.length; i++){
		var temp;
		amt = parseFloat($(amount[i]).inputmask('unmaskedvalue'))
		max = parseFloat($(maximum[i]).inputmask('unmaskedvalue'))
		min = parseFloat($(minimum[i]).inputmask('unmaskedvalue'))
		if(max < 0)
		{
			maximum[i].style.borderColor = 'red';
			error += "Maximum Required.";
		}
		else
		{
			maximum[i].style.borderColor = 'green';
			maximum_id_descrp.push(max);
			maximum_id.push(max);
			$('#ipf_warning').removeClass('in');
		}
		if(amt < 0)
		{
			amount[i].style.borderColor = 'red';
			error += "Amount Required.";
		}
		else
		{
			amount[i].style.borderColor = 'green';
			amount_value.push(amt);
			$('#ipf_warning').removeClass('in');
			
		}
		if(minimum[i].value === maximum[i].value){
			maximum[i].style.borderColor = 'red';
			error += "Same.";
		}


		if(min > max){

			console.log(min);
			console.log(max);
			maximum[i].style.borderColor = 'red';
			error += "Minimum is greater than maximum";
			$('#ipf_warning').addClass('in');

		}
		pair = {
			minimum: $(minimum[i]).inputmask('unmaskedvalue'),
			maximum : $(maximum[i]).inputmask('unmaskedvalue')
		};
		range_pairs.push(pair);
	}

	var i, j, n;
	found= false;
	n=range_pairs.length;
	for (i=0; i<n; i++) {
		for (j=i+1; j<n; j++)
		{
			if (range_pairs[i].minimum === range_pairs[j].maximum && range_pairs[i].maximum === range_pairs[j].maximum){
				found = true;

				maximum[i].style.borderColor = 'red';
				minimum[j].style.borderColor = 'red';
				maximum[j].style.borderColor = 'red';
			}
		}
	}
	if(found == true){
		error+= "Existing rate.";
	}

		if(error.length == 0){

			return true;
		}
		else
		{
			return false;
		}
	}
	function finalvalidateIpfRows()
	{
		minimum_id = [];
		maximum_id = [];
		amount_value = [];
		minimum_id_descrp = [];
		maximum_id_descrp = [];
		amount_value_descrp = [];
		range_pairs = [];
		minimum = document.getElementsByName('minimum');
		maximum = document.getElementsByName('maximum');
		amount = document.getElementsByName('amount');

		error = "";

		var min, max, amt;
		if($('#dateEffective').val() == ""){
			document.getElementById("dateEffective").style.borderColor = "red";
			error += "Date Effective Required.";
		}


		for(var i = 0; i < minimum.length; i++){
			amt = parseFloat($(amount[i]).inputmask('unmaskedvalue'))
			max = parseFloat($(maximum[i]).inputmask('unmaskedvalue'))
			min = parseFloat($(minimum[i]).inputmask('unmaskedvalue'))

			if(min < 0)
			{
				error += "Minimum Required.";
				$('#ipf_warning').addClass('in');
			}
			else
			{
				minimum_id_descrp.push(min);
				var min = $(minimum[i]).inputmask('unmaskedvalue');
				minimum_id.push(min);
			}
			if(max < 0)
			{
				maximum[i].style.borderColor = 'red';
				error += "Maximum Required.";
				$('#ipf_warning').addClass('in');
			}
			else
			{
				maximum[i].style.borderColor = 'green';
				maximum_id_descrp.push(max);
				maximum_id.push(max);
				$('#ipf_warning').removeClass('in');
			}
			if(amt < 0)
			{
				amount[i].style.borderColor = 'red';
				error += "Amount Required.";
				$('#contract_rates_warning').addClass('in');
			}
			else
			{
				
				amount[i].style.borderColor = 'green';
				amount_value.push(amt);
				$('#ipf_warning').removeClass('in');
				
			}
			if(minimum[i].value === maximum[i].value){
				maximum[i].style.borderColor = 'red';
				error += "Same.";
				$('#ipf_warning').addClass('in');
			}


			if( min > max ){
				maximum[i].style.borderColor = 'red';
				error += "Minimum is greater than maximum";
				$('#ipf_warning').addClass('in');
			}
			pair = {
				minimum: minimum[i].value,
				maximum: maximum[i].value
			};
			range_pairs.push(pair);
		}
		var i, j, n;
		found= false;
		n=range_pairs.length;
		for (i=0; i<n; i++) {
			for (j=i+1; j<n; j++)
			{
				if (range_pairs[i].minimum === range_pairs[j].minimum && range_pairs[i].maximum === range_pairs[j].maximum){
					found = true;

					maximum[i].style.borderColor = 'red';
					maximum[j].style.borderColor = 'red';
				}
			}
		}
		if(found == true){
			error+= "Existing rate.";
			$('#ipf_warning').addClass('in');
		}
		if(error.length == 0){
			tblLength = minimum.length;
			return true;
		}
		else
		{
			return false;
		}
	}
	function resetErrors() {
		$('form input, form select').removeClass('inputTxtError');
		$('label.error').remove();
	}
</script>
@endpush
