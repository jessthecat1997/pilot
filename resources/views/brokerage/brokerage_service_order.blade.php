@extends('layouts.app')
@section('content')
<div class = "row">
	<div class = "col-md-8 col-md-offset-2">
		<div class = "panel panel-default">
			<div class = "panel-heading">
				<h2>&nbsp;New Brokerage Service Order</h2>
			</div>
			<div class = "panel-body">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><h4><small>1</small>&nbsp;           Consignee Details</h4></a></h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
							<div class="panel-body">
								<div class = "panel-default ">
									<div class= "panel-heading">
										<h5>Basic Information</h5>
										<hr />
									</div>
									<div class = "collapse" id = "collapse_1">
										<ul class="nav nav-tabs">
											<li class = "active"><a data-toggle="tab" href="#new_con">New</a></li>
											<li><a data-toggle="tab" href="#old_con">Old</a></li>
										</ul>

										<div class="tab-content">
											<div id="old_con" class="tab-pane fade">
												<br />
												<table class = "table table-responsive" id = "cs_table">
													<thead>
														<tr>
															<td>
																Full Name
															</td>
															<td>
																Created At
															</td>
															<td>
																Actions
															</td>
														</tr>
													</thead>
												</table>
											</div>
											<div id="new_con" class="tab-pane fade in active">
												<br />
												<form class="form-horizontal" role="form">
													{{ csrf_field() }}
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
														<div class="col-sm-offset-5 col-sm-10">
															<input type = "submit" class = "btn btn-info btn-md" id = "btnConsigneeSave" value = "Create Consignee"/>
															<input type = "reset" class = "btn btn-danger btn-md" value = "Clear Details" />
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class = "collapse" id = "collapse_2">
										<form class="form-horizontal" >
											{{ csrf_field() }}
											<div class="form-group">
												<label class="control-label col-sm-4" for="_firstName">Full Name:</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name = "_firstName" id="_firstName" placeholder="Enter First Name">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><h4><small>2</small>&nbsp;           Brokerage Details</h4></a></h4>
						</div>
						<div id="collapse2" class="panel-collapse collapse">
							<div class="panel-body">
								<form class="form-horizontal" role="form">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="control-label col-sm-4" for="firstName">Received through: *</label>
										<div class="col-sm-6">
											<select class = "form-control" name = "receiveType">
												<option></option>
												@forelse($rts as $rt)
												<option value = "{{ $rt->id }}">{{ $rt->description }}</option>
												@empty

												@endforelse
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-4" for="firstName">Date of Arrival: *</label>
										<div class="col-sm-6">
											<input type = "date" name = "dateArrival" class = "form-control" />
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><h4><small>3</small>&nbsp;           Employee Details</h4></a></h4>
						</div>
						<div id="collapse3" class="panel-collapse collapse">
							<div class="panel-body">

							</div>
						</div>
					</div>
				</div>
				<input type = "submit" class = "btn btn-md btn-info pull-right disabled"/>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	var data;
	$(document).ready(function(){
		var cstable = $('#cs_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'http://localhost:8000/csData',
			columns: [

			{ data: 'firstName' },
			{ data: 'created_at' },
			{ data: 'action', orderable: false, searchable: false }

			],

		});

		$(document).on('click', '.selectConsignee' ,function(e){

			$('#collapse_1').removeClass('in');
			$('#collapse_2').addClass('in');
			var cs_id = $(this).val();
			data = cstable.row($(this).parents()).data();
			$('#_firstName').val(data.firstName);

		})

		$(document).on('click', '.panel-title' , function(e){
			if($('#_firstName').val() == ""){

				$('#collapse_1').addClass('in');
				$('#collapse_2').removeClass('in');

			}

		})

		$('#btnConsigneeSave').on('click', function(e){
			e.preventDefault();

			$.ajax({
				type: 'POST',
				url: '{{ route("consignee.store") }}',
				data: {
					'_token' : $('input[name=_token]').val(),
					'firstName' : $('input[name=firstName]').val(),
					'middleName' : $('input[name=middleName]').val(),
					'lastName' : $('input[name=lastName]').val()
				},
				success: function (data) {
					if(typeof(data) == "object"){
						$('#collapse_1').removeClass('in');
						$('#collapse_2').addClass('in');
						$('#_firstName').val($('#firstName').val() + " " + $('#middleName').val() + " " + $('#lastName').val());

						cstable.ajax.reload();
						$('#firstName').val("");
						$('#middleName').val("");
						$('#lastName').val("");
					}
				}
			})
		})
	});

</script>
@endpush
