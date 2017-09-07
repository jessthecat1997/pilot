@extends('layouts.maintenance')
@push('styles')
<style>
	.class-cargo-type
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
@section('content')
<div class = "container-fluid">
	<div class = "row">
		<h2>&nbsp;Maintenance | Brokerage | Cargo Type</h2>
		<hr>

		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#cargoTypeModal" style = "width: 100%;">New Cargo Type</button>
		</div>
	</div>
    <br/>
  <div class = "row">
    <div class = "panel-default panel">
      <div class = "panel-body">
        <table class = "table-responsive table" id = "Cargo_Type">
          <thead>
            <tr>
              <td>
                ID
              </td>
              <td>
                Name
              </td>
              <td>
                Description
              </td>
              <td>
                Actions
              </td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <section class="content">
    <form role="form" method = "POST" id ="commentForm" >
      {{ csrf_field() }}
      <div class="modal fade" id="cargoTypeModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">New Cargo Type</h4>
            </div>
            <div class="modal-body">

              <div class="form-group required">
                <label class = "control-label">Name</label>


                  <input type = "text"   class = "form-control" name = "fee" id = "name"  data-rule-required="true" />

              </div>

              <div class="form-group required">
                <label class = "control-label">Description</label>
                <textarea  class = "form-control" name = "dateEffective" id="description" data-rule-required="true"/> </textarea>

              </div>


              <small style = "color:red; text-align: left"><i>All field(s) with (*) are required.</i></small>

            </div>
            <div class="modal-footer">
              <input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>

          </div>
        </div>
      </div>
    </form>
  </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
var cargo_type_table = $('#Cargo_Type').DataTable({
  processing: false,
  serverSide: false,
  deferRender:true,
  ajax: 'http://localhost:8000/admin/cargoTypeData',
  columns: [
    { data: 'id' },
    { data: 'name' },
    { data: 'description' },
    { data: 'action', orderable: false, searchable: false }

    ],	"order": [[ 0, "desc" ]],
  });

  $('#btnSave').on('click', function(e){



    e.preventDefault();
    var title = $('.modal-title').text();

    if(title == "New Cargo Type")
    {
      $.ajax({
        type: 'POST',
        url:  '/admin/cargo_type',
        data: {
          '_token' : $('input[name=_token]').val(),
          'name' : $('#name').val(),
          'description' : $('#description').val(),

        },
        success: function (data)
        {


          if(typeof(data) === "object"){
            cargo_type_table.ajax.reload();
            $('#cargoTypeModal').modal('hide');
            $('.modal-title').text('New Cargo Type');
            $('#fee').val('');
            $('#dateEffective').val('');

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
            toastr["success"]("Record added successfully");

          }else{

            resetErrors();
            var invdata = JSON.parse(data);
            $.each(invdata, function(i, v) {
              console.log(i + " => " + v);
              var msg = '<label class="error" for="'+i+'">'+v+'</label>';
              $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
            });

          }
        },

      })
    }
    else
    {


    }
  });
</script>
@endpush
