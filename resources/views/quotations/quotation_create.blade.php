@extends('layouts.app')
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<div class = "col-md-10 col-md-offset-1">
			<div class = "panel-default panel">
				<div class = "panel-heading">
					<h2 id = "page_title">Quotation</h2>
				</div>
				<div class = "panel-body">
					<div class = "col-md-12">
						<h3 id = "con-info-header"><small>1</small>&nbsp;&nbsp;Consignee Information</h3>
						<div class = "collapse" id = "consignee_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> No selected consignee.
							</div>
						</div>
						<div class = "panel-default">
							<div id="con_collapse" class="collapse in">
								<ul class="nav nav-tabs">
									<li><a data-toggle="tab" href="#new_con">New</a></li>
									<li class = "active"><a data-toggle="tab" href="#old_con">Old</a></li>
								</ul>

								<div class="tab-content">
									<div id="old_con" class="tab-pane fade in active">
										<br />

										<table class="table table-responsive" id = "cs_table">
											<thead>
												<tr>
													<td width="25%">
														Full Name
													</td>
													<td width="25%">
														Company Name
													</td>
													<td width="25%">
														Email
													</td>
													<td width="10%">
														Action
													</td>
												</tr>
											</thead>
										</table>

									</div>
									<div id="new_con" class="tab-pane fade">
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
											<div class="form-group required">
												<label class="control-label col-sm-4" for="email">Email</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "email" id="email" placeholder="Enter Email Address">
												</div>
											</div>
											<div class="form-group required">
												<label class="control-label col-sm-4" for="address">Address:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "address" id="address" placeholder="Enter Address">
												</div>
											</div>
											<div class="form-group required">
												<label class="control-label col-sm-4" for="contactNumber">Contact Number:</label>
												<div class="col-sm-6">          
													<input type="text" class="form-control" name = "contactNumber" id="contactNumber" placeholder="Enter Contact Number">
												</div>
											</div>
											<div class="form-group">        
												<div class="col-sm-offset-5 col-sm-10">
													<button class = "btn btn-info btn-md" id = "btnConsigneeSave" >Save Consignee</button>
													<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
												</div>
											</div>
										</form>	
									</div>
								</div>
							</div>
							<div id ="detail_collapse" class = "collapse">
								<form class="form-horizontal" role="form">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="control-label col-sm-3" for="pwd">Full Name:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_lastName" id="_lastName" placeholder="Enter Last Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="companyName">Company Name:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_companyName" id="_companyName" placeholder="Enter Company Name">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="email">Email</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_email" id="_email" placeholder="Enter Email Address">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3" for="contactNumber">Contact Number:</label>
										<div class="col-sm-8">          
											<input type="text" disabled class="form-control" name = "_contactNumber" id="_contactNumber" placeholder="Enter Contact Number">
										</div>
									</div>
								</form>	
							</div>
							
						</div>
						<hr />
						<h3 id = "contract_duration_title"><small>2</small>&nbsp;&nbsp;Contract Duration</h3>
						<br />
						<div class = "collapse" id = "contract_duration_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the duration.
							</div>
						</div>
						<form class = "form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-3" for="dateEffective">Date Effective:</label>
								<div class="col-sm-8">
									<input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="dateExpiration">Date Expiration:</label>
								<div class="col-sm-8">
									<input type="date" class="form-control" name = "dateExpiration" id="dateExpiration" placeholder="Enter Expiration Date">
								</div>
							</div>
						</form>

						<br />
						<br />
					</div>
					<div class = "col-md-12">
						<hr />
						<h3 id = "contract_rate_title"><small>3</small>&nbsp;&nbsp;Contract Rates</h3>
						<br />
						<div class = "collapse" id = "contract_rates_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Something is wrong with the rates.
							</div>
						</div>
						<div class = "col-md-12" style="overflow-x: auto;">
							<div class = "panel-default">
								<form id = "contract_rates_form">
									<table class="table responsive table-hover" width="100%" id= "contract_parent_table" style = "overflow-x: scroll;">
										<thead>
											<tr>
												<th width="30%">
													<strong>Area From</strong>
												</th>
												<th width="30%">
													<strong>Area To</strong>
												</th>

												<th width="30%">
													<strong>Amount</strong>
												</th>
												<th width="10%" style="text-align: center;">
													<strong>Action</strong>
												</th>
											</tr>
										</thead>
										<tr id = "contract-row">
											<td>
												<select name = "areas_id_from" id = "areas_id_from" class = "form-control area_from_valid" required = "true">
													<option></option>
												</select>
											</td>
											<td>
												<select name = "areas_id_to" id = "areas_id_to" class = "form-control area_to_valid" required="true">
													<option>

													</option>
													
												</select>
											</td>

											<td>
												<input type = "number" name = "amount" class = "form-control amount_valid" style="text-align: right">

											</td>
											<td style="text-align: center;">
												<button class = "btn btn-danger btn-md delete-contract-row">x</button>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
						<div class="row">
							<div class = "col-md-4">
								<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new-contract-row pull-left">New Rate</button>
							</div>
							<div class = "col-md-4">

							</div>
							<div class = "col-md-4">
								<a class = "btn pull-left" data-target="#arModal" data-toggle = "modal">+ New Area</a>
							</div>
						</div>
					</div>
					<br />
					<div class="col-md-12">
						<hr />
						<h3><small>4</small>&nbsp;&nbsp;Terms &amp; Conditions</h3>
						<div class = "collapse" id = "term_condition_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Terms and Condition(s) is required.
							</div>
						</div>
						<div class = "collapse" id = "term_condition_count_warning">
							<div class="alert alert-danger">
								<strong>Warning!</strong> Requires at least one term and condition.
							</div>
						</div>
						<div class = "col-md-12">
							<table style="width: 100%;" class="table table-responsive" id = "term_table">
								<thead>
									<tr>
										<th style="width: 95%;">
											Description
										</th>
										<th style="width: 5%; text-align: center;">
											Action
										</th>
									</tr>
								</thead>
								<tbody>
									<tr id = "term-condition-row">
										<td>
											<textarea class = "form-control specificDetails" style = "max-width: 100%; min-width: 100%;" placeholder="Enter Terms and Conditions . . . " name = "specificDetails"></textarea>
										</td>
										<td style="text-align: center;">
											<button class = "btn btn-danger btn-md delete-term-row">x</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<div classs = "col-md-8">

							</div>
							<div class = "col-md-4" style="text-align: center;">
								<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new-term-row pull-right">New Term &amp; Condition</button>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h3><small>5</small>&nbsp;&nbsp;Finalize</h3>
						<div style=" text-align: center;">
							<button class = "btn btn-md btn-success finalize-contract" style = "width: 100%;">Create Contract</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="arModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Area</h4>
						</div>
						<div class="modal-body">			
							<div class="form-group required">
								<label class = "control-label">Name: </label>
								<input type = "text" class = "form-control" name = "description" id = "description"  minlength = "2" data-rule-required="true" />
								
							</div>
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
@endsection

@push('styles')
<style>
	.quotation
	{
		border-left: 10px solid #2ad4a5;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush