@extends('layouts.app')
@section('content')
<div class = "row">
		<div class = "panel default-panel">
			<div class = "panel-heading">
				<h3><img src="/images/bar.png"> Employee | Create Employee</h3>
				<hr />
			</div>

      <div class = "panel-body">
				<div class = "panel-heading">
					<h4><small>1</small>&nbsp;&nbsp;Employee Roles</h4>
				</div>


				@php
					$checkboxCtr = 0;
					$employeeTypeId = array();
				@endphp
        <div class = "form-group">
            <div class = "col-md-12">
              @forelse($employee_role as $employee_roles)
              <div class = "col-md-3" id = "employeeRoles">
                <input type="checkbox"  data-toggle="toggle" data-size="normal" data-on="" data-off="" data-onstyle="success"  id = "employeeType_toggle[{{ $checkboxCtr  }}]"  >
						    &nbsp;&nbsp;{{$employee_roles->name }}
              </div>

							@php
								$checkboxCtr++;
								$employeeTypeId[$checkboxCtr] = $employee_roles->id;
							@endphp

              @empty
								<label> No employee Types found </label>
              @endforelse
          </div>
        </div>

        <br />
				<div class = "panel-heading">
					<h4><small>2</small>&nbsp;&nbsp;Employee Information</h4>
				</div>



					<div class="panel-body">
						<div class = "tab-content">
										<br />
											<div class = "col-md-12">
						<div class = "form-horizontal">
              <form role = "form" class="form-horizontal" method = "POST">
                {{ csrf_field() }}
                <div class="form-group">
          				    <div class = "col-md-12">
									        <div class = "col-md-4">
                            <label>First Name *</label>
                            <input  type="text" class="form-control" name = "freightnumber" id = "firstName">
                          </div>
                          <div class = "col-md-4">
                              <label>Middle Name</label>
                            <input  type="text" class="form-control" name = "freightnumber" id = "middleName">
                          </div>
                          <div class = "col-md-4">
                            <label>Last Name *</label>
                            <input  type="text" class="form-control" name = "freightnumber" id = "lastName">
                          </div>
											</div>
								</div>

                <div class = "col-md-12">
                  <label>Current Address</label>
                </div>
                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-5">
                      <label class= " control-label">Street</label>
                      <input type="text" class = "form-control" name="age" id = "street">
                    </div>

                    <div class = "col-md-3">
                      <label class= " control-label">Province</label>
                      <select name = "loc_province" id="loc_province" class = "form-control">
                      </select>
                    </div>

                    <div class = "col-md-3">
                      <label class= " control-label">City</label>
                      <select name = "loc_city" id="loc_city" class = "form-control">
                        <option value="0"></option>
                      </select>
                    </div>


                  </div>
                  <div class = "col-md-12">
                    <div class = "col-md-2">
                      <label class= " control-label">Zip Code</label>
                      <input type="text" class = "form-control" name="age" id = "zip">
                    </div>
                  </div>
                </div>

                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-3">
                      <label class= " control-label">Date Of Birth*</label>
                        <div class = "input-group">
                          <input type="text" class = "form-control" name="dateOfBirth" id = "dateOfBirth" disabled>
                          <span class="input-group-btn">
                              <button class="btn btn-default" type="button" onclick="getData()" id = "dateOfBirthButton"><i class="fa fa-calendar "></i></button>
                          </span>
                        </div>
                    </div>

                    <div class = "col-md-2">
                      <label class= " control-label">Age</label>
                      <input type="text" class = "form-control" name="age" id = "age" disabled>
                    </div>

                    <div class = "col-md-3">
                      <label class= " control-label">Social Security Number*</label>
                          <input type="text" class = "form-control" name="sss" id = "socialSecurityNumber" >
                    </div>
                  </div>
                </div>



                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-3">
                      <label class= " control-label">Phone Number*</label>
                      <input type="text" class = "form-control" name="age" id = "phoneNumber" placeholder="xxx-xx-xx">
                    </div>

                    <div class = "col-md-3">
                      <label class= " control-label">Cellphone Number*</label>
                      <input type="text" class = "form-control" name="age" id = "cellphoneNumber"  placeholder="(xx)-xxxxxxxxx">
                    </div>
                  </div>
                </div>

                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-3">
                      <label class= " control-label">Emergency Contact</label>
                      <input type="text" class = "form-control" name="age" id = "emergencyContact" placeholder="xxx-xx-xx">
                    </div>


                  </div>
                </div>

                <div class="form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-6">
                      <label class=" control-label">In case of emergency</label>

                          <textarea class="form-control" rows="3" id = "inCaseOfEmergency"></textarea>

                    </div>
                  </div>
                </div>


                </form>
								</div>
						</div>
        </div>

		</div>

	                  <div class="form-group">
                        <hr>
	                     <label class = "col-md-12 control-label">
												 <form role = "form" class="form-horizontal" method = "POST">
													 {{ csrf_field() }}
	                       <button  class="btn btn-success" id = "saveRecord" >
	                          Save Record
	                       </button>
	                     </label>
										 </form>
	                     <p class = "col-md-12">Note: All fields with the '*' are required</p>
										 </div>

									 </div>
								 </div>
		</div>



  </div>
</div>

@endsection
@push('styles')
<link href="/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
	.employees
	{
		border-left: 10px solid #8ddfcc;
		background-color:rgba(128,128,128,0.1);
		color: #fff;
	}
</style>
@endpush

@push('scripts')

<script src="/js/bootstrap-toggle.min.js"></script>
<script>
	$('#collapse1').addClass('in');

var arr_provinces =[
@forelse($provinces as $province)
{ id: '{{ $province->id }}', text:'{{ $province->name }}' },
@empty
@endforelse
];

var checkboxCtr = <?php echo $checkboxCtr ?>

$('#dateOfBirth').datepicker({
    onSelect: function(value, ui) {
        var today = new Date(),
            dob = new Date(value),
            age = new Date(today - dob).getFullYear() - 1970;

        document.getElementById('age').value = age;
    },
    maxDate: '+0d',
    yearRange: '1920:2010',
    changeMonth: true,
    changeYear: true
});

$('#dateOfBirthButton').click(function () {
 $('#dateOfBirth').datepicker('show');
 });

	$(document).ready(function(){

		var checkedCheckBoxesValueArray = $('#employeeRoles input:checkbox:checked').map(
  			function(){
    		return this.value;
		}).get();

		$(document).on('click', '#saveRecord', function(e){


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
			console.log('date of birth: '+document.getElementById("dateOfBirth").value);
			console.log('age: '+$('#age').val());
			console.log('social security number: '+$('#socialSecurityNumber').val());
			console.log('phone number: '+$('#phoneNumber').val());
			console.log('cellphone number: '+$('#cellphoneNumber').val());
			console.log('emergency contact: '+$('#emergencyContact').val());
			console.log('in case of emergency: '+$('#inCaseOfEmergency').val());
			console.log('toggles: '+JSON.stringify(trueToggle));

			var dob = document.getElementById("dateOfBirth").value;
			alert(dob);

			e.preventDefault();
			$.ajax({
				type: 'POST',

				url: '/StoreEmployee',
				data: {
					'_token' : $('input[name=_token]').val(),
          'firstName' : $('#firstName').val(),
          'middleName': $('#middleName').val(),
          'lastName' : $('#lastName').val(),
          'streetName' : $('#street').val(),
          'city' :  $('#loc_city').val(),
					'zip' : $('#zip').val(),
					'dateOfBirth': document.getElementById("dateOfBirth").value,
          'age': $('#age').val(),
          'socialSecurityNumber': $('#socialSecurityNumber').val(),
          'phoneNumber': $('#phoneNumber').val(),
          'cellphoneNumber': $('#cellphoneNumber').val(),
          'emergencyContact': $('#emergencyContact').val(),
          'inCaseOfEmergency': $('#inCaseOfEmergency').val(),
          'toggles': JSON.stringify(trueToggle),

				},
				success: function(data){

					window.location.replace(+data+"/view");
				
				},

			})
		});

    $("#loc_city").select2({
      width: '100%',
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

    document.getElementById('phoneNumber').addEventListener('input', function (e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,2})/);
      e.target.value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
    });

    document.getElementById('cellphoneNumber').addEventListener('input', function (e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,6})/);
      e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? + x[3] : '');
    });



});
</script>
@endpush
