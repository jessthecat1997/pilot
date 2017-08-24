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
              @forelse($employee_roles as $employee_role)
              <div class = "col-md-2" id = "employeeRoles">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;{{$employee_role->name }}

              </div>

							@php
								$checkboxCtr++;
								$employeeTypeId[$checkboxCtr] = $employee_role->id;
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
                            <label style = "font-size: 18px;">Name</label>
                          </div>
                          <div class = "col-md-12" style = "font-size: 18px;">
                          {{ $employees[0]->firstName }}&nbsp;{{$employees[0]->middleName }}&nbsp;{{ $employees[0]->lastName}}
                          </div>
											</div>

								</div>


                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-4">
                    <label style = "font-size: 18px;">Current Address</label>
                  </div>
                  <div class = "col-md-12" style = "font-size: 18px;">
                  {{ $employee_details[0]->address }}&nbsp;{{ $employee_details[0]->city }}&nbsp;{{ $employee_details[0]->province}} &nbsp;
                  </div>
                  </div>
                </div>



                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-4">
                    <label style = "font-size: 18px;">Date Of Birth</label>
                    </div>

                    <div class = "col-md-4">
                    <label style = "font-size: 18px;">Age</label>
                    </div>

                    <div class = "col-md-4">
                    <label style = "font-size: 18px;">Social Security Number</label>
                    </div>

                    <div class = "col-md-4" style = "font-size: 18px;">
                    {{ $employee_details[0]->dateOfBirth }}
                    </div>

                    <div class = "col-md-4" style = "font-size: 18px;">
                    {{ $employee_details[0]->age }}
                    </div>

                    <div class = "col-md-4" style = "font-size: 18px;">
                    {{ $employee_details[0]->socialSecurityNumber }}
                    </div>
                  </div>
                </div>

                <div class = "form-group">
                  <div class = "col-md-9">
                    <div class = "col-md-5">
                    <label style = "font-size: 18px;">Phone Number</label>
                    </div>

                    <div class = "col-md-5">
                    <label style = "font-size: 18px;">Cellphone Number</label>
                    </div>
                    <div class = "col-md-5" style = "font-size: 18px;">
                    {{ $employee_details[0]->phoneContact }}
                    </div>
                    <div class = "col-md-5" style = "font-size: 18px;">
                    {{ $employee_details[0]->cellphoneContact }}
                    </div>
                  </div>
                </div>


                <div class = "form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-4">
                    <label style = "font-size: 18px;">Emergency Contact</label>
                    </div>


                    <div class = "col-md-12" style = "font-size: 18px;">
                    {{ $employee_details[0]->emergencyContact }}
                    </div>

                  </div>
                </div>


                <div class="form-group">
                  <div class = "col-md-12">
                    <div class = "col-md-6">
                      <label class=" control-label">In case of emergency</label>

                          <textarea class="form-control" rows="3" id = "inCaseOfEmergency" disabled>{{ $employee_details[0]->inCaseOfEmergency}}</textarea>

                    </div>
                  </div>
                </div>


                </form>
								</div>
						</div>
        </div>

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
@endpush
