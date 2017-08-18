@extends('layouts.maintenance')
@section('content')
@push('styles')
<style>
	.class-quotation-template
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
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Quotation Terms and Condition Template</h2>
		<hr>
		<div class = "col-md-3 col-md-offset-9">
			<button  type = "submit" style="" class = "btn btn-primary  btn-md update_term_condition ">Update Terms and Condition</button>
		</div>
	</div>
	<br />
	<div class = "row">
		<div class = "panel default-panel">
			<div class = "panel-body">
				<div style = "overflow-y: scroll; overflow-wrap: none; height:100%;" class="panel-default panel">

					@if($quotation[0]->terms == null)
					<h5 style="text-align: center;">No specified terms and condition details</h5>
					@else
					<p>
						<pre class = "actualterms">{!! $quotation[0]->terms !!}</pre>
						<input type = "hidden" class = "terms" value="{{ $quotation[0]->terms }}" />
					</p>

					@endif
				</div>
			</div>
		</div>
	</div>

	<section class="content">
		<form role="form" method = "POST" id = "commentForm">
			{{ csrf_field() }}
			<div class="modal fade" id="tcModal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Update Term &amp; Condition</h4>
						</div>
						<div class="modal-body">			

							<table class="table table-striped" id = "term_table" style="width: 100%;">
								<thead>
									<tr>
										<td style="width: 95%;">
											<strong>terms</strong>
										</td>
										<td style="width: 5%;">
											<strong>Action</strong>
										</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<div class="row">
								<div class = "col-md-4">
									<button  type = "submit" style="width: 100%;" class = "btn btn-primary btn-sm new_term_rate pull-left">New Term and Condition</button>
								</div>
								<div class = "col-md-8">

								</div>
							</div>
							<br />
						</div>
						<div class="modal-footer">
							<input id = "btnSave" type = "submit" class="btn btn-success update_contract_term_save" value = "Save" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>				
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>


	@endsection
	@push('styles')
	<style>
		.contracts
		{
			border-left: 10px solid #2ad4a5;
			background-color:rgba(128,128,128,0.1);
			color: #fff;
		}
		pre {border: 0; background-color: transparent;}
	</style>
	@endpush

	@push('scripts')
	<script type="text/javascript">
		var detail = "";
		var error = "";
		var temp_terms = null;
		var term_row = "<tr><td><textarea class = 'form-control' name = 'terms' onkeyup='textAreaAdjust(this)' style='overflow:hidden'></textarea></td><td><button class = 'btn btn-danger remove_term_row'>x</button></td></tr>";

		$(document).ready(function(){
			

			$(document).on('click', '.update_term_condition', function(e){
				e.preventDefault();

				$('#term_table > tbody').html("");

				var unsplit = $('.terms').val();
				temp_terms = unsplit;
				var details = unsplit.split('<br />');

				details.pop();
				
				var detail_html = "";
				for(var i = 0; i < details.length; i++)
				{

					detail_html += "<tr><td><textarea onkeyup='textAreaAdjust(this)' style='overflow:hidden' rows = '2' style= 'border-color: green;' name = 'terms' class = 'form-control'>"+ details[i].substring(3, details[i].length) +"</textarea></td><td><button class = 'btn btn-danger remove_term_row'>x</button></td></tr>"
					
				}
				$('#term_table > tbody').append(detail_html);
				
				$('#tcModal').modal('show');
			})

			$(document).on('click', '.remove_term_row', function(e){
				e.preventDefault();
				$(this).closest('tr').remove();
			})

			$(document).on('click', '.new_term_rate', function(e){
				e.preventDefault();
				if(validate() === true){
					$('#term_table > tbody').append(term_row);
				}
			})

			

			$(document).on('click', '.update_contract_term_save', function(e){
				e.preventDefault();
					console.log(temp_terms);
				if(validate() ===  true){
					if(detail == temp_terms  )
					{
						$('#tcModal').modal('hide');
					}else{

						$.ajax({
							type: 'PUT',
							url:  '/admin/quotation_template/'+ 1,
							data: {
								'_token' : $('input[name=_token').val(),
								'terms' : detail,
							},
							success: function (data)
							{
								$('.terms').val(data.terms);
								$('.actualterms').html(data.terms);

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

								$('#tcModal').modal('hide');
							}
						});

					}
					
				} //if validate
			})
		});
		function textAreaAdjust(o) {
			o.style.height = "1px";
			o.style.height = (25+o.scrollHeight)+"px";
		}

		function validate(){
			var term = [];
			error = "";
			detail = "";
			term_descrp = document.getElementsByName('terms');
			for(var i = 0; i < term_descrp.length; i++)
			{
				if(term_descrp[i].value === "")
				{
					term_descrp[i].style.borderColor = 'red';
					error += "Term is required";
				}
				else
				{
					term.push(term_descrp[i].value);
					detail += (i + 1) + ". " + term_descrp[i].value + "<br />";
					term_descrp[i].style.borderColor = 'green';
				}
			}

			if(error.length == 0)
			{
				return true;
				
			}else
			{
				return false;
			}
		}
	</script>
	@endpush