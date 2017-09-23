@extends('layouts.maintenance')
@push('styles')
<style>
	.class-wharfage-fee
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
		<h2>&nbsp;Maintenance | Brokerage | Wharfage Fee</h2>
		<hr>

		<div class = "col-md-3 col-md-offset-9">
			<button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#wharfageFeeModal" style = "width: 100%;">New Wharfage Fee</button>
		</div>
	</div>
  <br/>
  <div class = "row">
    <div class = "panel-default panel">
      <div class = "panel-body">
        <table class = "table-responsive table" id = "wharfage_table">
          <thead>
            <tr>
              <td>
                Location
              </td>
              <td>
                Fee
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
      <div class="modal fade" id="wharfageFeeModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">New Wharfage Fee</h4>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <div class="form-group required">
                  <label class = "col-md-4 control-label ">Location </label>

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

              <div class="form-group required">
                <label class = "control-label">Fee</label>
                <div class = "form-group input-group " >
                  <span class = "input-group-addon">Php</span>
                  <input type = "text"   class = "form-control money" name = "fee" id = "fee"  data-rule-required="true" value="0.00" />
                </div>


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


  <!-- Add Item Modal -->

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

</div>


@endsection

@push('scripts')
<script type="text/javascript">
var wharfage_table = $('#wharfage_table').DataTable({
  processing: false,
  serverSide: false,
  deferRender:true,
  ajax: 'http://localhost:8000/admin/wfData',
  columns: [
    { data: 'location' },
    { data: 'fee' },
    { data: 'action', orderable: false, searchable: false }

    ],	"order": [[ 0, "desc" ]],
  });

  $(document).on('change', '#loc_province', function(e){
		fill_cities(0);
	})
  
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
</script>
@endpush
