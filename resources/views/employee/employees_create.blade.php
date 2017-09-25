@extends('layouts.app')
@section('content')
<div class = "col-md-12">
  <div class = "panel panel-default">
    <div class = "panel-heading">
      <h4>New Employee</h4>
    </div>
    <div class = "panel-body">
      <div class = "col-md-12">
        <form class = "" id="commentForm">
          {{ csrf_field() }}
          <div class="row">
            <h5>Basic Information</h5>
            <div class = "col-md-4">
              <div class = "form-group required">
                <label class="control-label">First Name</label>
                <input type = "text" class = "form-control" placeholder="First Name" id = "firstName" required />
              </div>
            </div>
            <div class = "col-md-4">
              <div class = "form-group">
                <label class="control-label">Middle Name</label>      
                <input type = "text" class = "form-control" placeholder="Middle Name" id = "middleName"/>
              </div>
            </div>
            <div class = "col-md-4">
              <div class = "form-group required">
                <label class="control-label">Last Name</label>
                <input type = "text" class = "form-control" placeholder="Last Name" id = "lastName" required />
              </div>
            </div>
          </div>
          <div class="row">
            <h5>Address</h5>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Blk/ Lot/ Street</label>
                <textarea class="form-control" id = "streetName"></textarea>
              </div>
            </div>
            <div class="col-md-8">
              <div class = "col-md-4">
                <div class="form-group">
                  <label class = "control-label">Province</label>
                  <select class="form-control" name = "loc_province" id="loc_province" ></select>
                </div>
              </div>
              <div class = "col-md-4">
                <div class="form-group">
                  <label class = "control-label">City</label>
                  <select class="form-control" name = "loc_city" id="loc_city"></select>
                </div>
              </div>
              <div class = "col-md-4">
                <div class="form-group">
                  <label class="control-label">Zip</label>
                  <input type = "text" id = "zip" class = "form-control"/>
                </div>
              </div>
            </div>
          </div>
          <div class = "row">
            <div class = "col-md-3">
              <div class="form-group required">
                <label class = "control-label">Date of Birth</label>
                <input type="text" class = "form-control" id = "dob" name="dob" required />
              </div>
            </div>
            <div class = "col-md-3">
              <div class="form-group">
                <label class = "control-label">Age</label>
                <input type="text" class="form-control" disabled style="text-align: right;" id = "age" />
              </div>
            </div>
            <div class = "col-md-3">
              <div class="form-group required">
                <label class="control-label">SSS No.</label>
                <input type = "text" class = "form-control" id = "SSSNo" name="SSSNo" />
              </div>
            </div>
            <div class = "col-md-3">
              <div class="form-group required">
                <label class="control-label">Contact No.</label>
                <input type = "text" id = "contactNumber" name="contactNumber" class = "form-control" required />
              </div>
            </div>
          </div>
          <div class="row">
            <h5>Employee Roles</h5>
            @php
            $checkboxCtr = 0;
            $employeeTypeId = array();
            @endphp
            <div class = "form-group">
              <div class = "col-md-12">
                @forelse($employee_role as $employee_roles)
                <div class = "col-md-3" id = "employeeRoles">
                  <input type="checkbox"  data-toggle="toggle" data-size="normal" data-on="" data-off="" data-onstyle="success"  id = "employeeType_toggle[{{ $checkboxCtr  }}]"  >&nbsp;&nbsp;{{$employee_roles->name }}
                </div>

                @php
                $checkboxCtr++;
                $employeeTypeId[$checkboxCtr] = $employee_roles->id;
                @endphp

                @empty
                <label>No employee Types found</label>
                @endforelse
              </div>
            </div>
          </div>
          <div class="row">
            <h5>In Case of Emergency:</h5>
            <div class = "col-md-12">
              <div class="form-group">
                <textarea class="form-control" id = "inCaseOfEmergency" name="inCaseOfEmergency"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class = "col-md-8">

            </div>
            <div class = "col-md-4">
              <button type = "button" class="btn btn-md btn-info" id = "saveRecord" style="width: 100%;">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="/js/jqueryDateTimePicker/jquery.datetimepicker.css">
@endpush
@push('scripts')
<script type="text/javascript" src = "/js/jqueryDateTimePicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    var arr_provinces =[
    @forelse($provinces as $province)
    { id: '{{ $province->id }}', text:'{{ $province->name }}' },
    @empty
    @endforelse
    ];

    $("#loc_city").select2({
      width: '100%',
      placeholder: "Select city",
      allowClear: true,
      sorter: function(data) {
        return data.sort(function (a, b) {
          if (a.text > b.text) {
            return 1;
          }
          if (a.text < b.text) {
            return -1;
          }
          return 0;
        });
      },
    });

    $("#loc_province").select2({
      data: arr_provinces,
      width: '100%',
      placeholder: "Select province",
      allowClear: true,
      sorter: function(data) {
        return data.sort(function (a, b) {
          if (a.text > b.text) {
            return 1;
          }
          if (a.text < b.text) {
            return -1;
          }
          return 0;
        });
      },
    });

    Inputmask("9{4}").mask($("#zip"));


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

    $('#dob').datetimepicker({
      mask:'9999/19/39',
      scrollInput: false,
      dayOfWeekStart : 1,
      timepicker: false,
      lang:'en',
      format:'Y/m/d',
      formatDate:'Y/m/d',
      value: "{{ Carbon\Carbon::now()->format('Y/m/d') }}",
      startDate:  "{{ Carbon\Carbon::now()->format('Y/m/d') }}",
      minDate:'2013/12/03',
      maxDate: "+1970/01/01",
      onSelectDate:function(ct,$i){
        var today = new Date();
        dob = new Date(ct);
        age = new Date(today - dob).getFullYear() - 1970;

        document.getElementById('age').value = age;
      }
    }); 

    $("#commentForm").validate({
      rules: 
      {
        firstName:
        {
          required: true,
        },

        lastName:
        {
          required: true,
          date: true,
        },
        dob:
        {
          required: true,
          date: true,
        }
      },
      onkeyup: false, 
      submitHandler: function (form) {
        return false;
      }
    });

    document.getElementById('contactNumber').addEventListener('input', function (e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,2})/);
      e.target.value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
    });

    var checkboxCtr = <?php echo $checkboxCtr ?>;
    var checkedCheckBoxesValueArray = $('#employeeRoles input:checkbox:checked').map(
      function(){
        return this.value;
      }).get();

    $(document).on('click', '#saveRecord', function(e){
      e.preventDefault();
      var trueToggle = new Array();
      var ctr = 0; ctr1 = 0;

      @forelse($employeeTypeId as $id)
      if(document.getElementById("employeeType_toggle["+ctr+"]").checked == true)
      {
        trueToggle[ctr1] = {{ $id }};
        ctr1++;
      }
      ctr++;
      @empty
      @endforelse

      console.log('first name: '+$('#firstName').val());
      console.log('middle name: '+$('#middleName').val());
      console.log('last name: '+$('#lastName').val());
      console.log('street name: '+$('#street').val());
      console.log('city name: '+$('#loc_city').val());
      console.log('date of birth: '+document.getElementById("dob").value);
      console.log('age: '+$('#age').val());
      console.log('social security number: '+$('#SSSNo').val());
      console.log('phone number: '+$('#contactNumber').val());
      console.log('cellphone number: '+$('#cellcontactNumber').val());
      console.log('emergency contact: '+$('#emergencyContact').val());
      console.log('in case of emergency: '+$('#inCaseOfEmergency').val());
      console.log('toggles: '+JSON.stringify(trueToggle));

      var dob = document.getElementById("dob").value;

      e.preventDefault();


      $('#firstName').valid();
      $('#lastName').valid();
      $('#dob').valid();
      $('#contactNumber').valid();
      $('#inCaseOfEmergency').valid();
      if($('#firstName').valid()){
        $.ajax({
          type: 'POST',

          url: '{{ route("EmployeeSave" )}}',
          data: {
            '_token' : $('input[name=_token]').val(),
              'firstName' : $('#firstName').val(),
              'middleName': $('#middleName').val(),
              'lastName' : $('#lastName').val(),
              'dob': document.getElementById("dob").value,
              'address' : $('#streetName').val(),
              'zip' : $('#zip').val(),
              'cities_id' :  $('#loc_city').val(),
              'SSSNo': $('#SSSNo').val(),
              'contactNumber': $('#contactNumber').val(),
              'inCaseOfEmergency': $('#inCaseOfEmergency').val(),
              'toggles': JSON.stringify(trueToggle),

            },
            success: function(data){

              window.location.replace(+data+"/view");

            },

          });
          }
          
        })
      })
    </script>
    @endpush