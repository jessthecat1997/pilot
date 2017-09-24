@extends('layouts.app')
@section('content')
<div class = "col-md-12">
  <div class = "panel panel-default">
    <div class = "panel-heading">
      <h4>Employee <small><strong>{{ $employee->id }}</strong></small>.</h4>
    </div>
    <div class = "panel-body">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Basic Information</a></li>
        <li><a data-toggle="tab" href="#menu1">Incidents</a></li>
        <li><a data-toggle="tab" href="#menu2">Accidents</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <div class="col-md-12">
            <div class="row">
              <h4>&nbsp;Basic Information</h4>
              <div class = "col-md-8">
                <div class = "form-group">
                  <label class="control-label col-md-3">Name:</label>
                  <span class="col-md-9">{{ $employee->firstName }} {{ $employee->middleName }} {{ $employee->lastName }}</span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">Date of Birth:</label>
                  <span class="col-md-9">{{ $employee->dob }}</span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">Age:</label>
                  <span class="col-md-9">{{ Carbon\Carbon::parse($employee->dob)->diffForHumans() }}</span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">SSS No.:</label>
                  <span class="col-md-9">{{ $employee->SSSNo }}</span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">Blk/Lot/Street:</label>
                  <span class="col-md-9">{{ $employee->address }} </span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">Province</label>
                  <span class="col-md-9">{{ $location[0]->city }} , {{ $location[0]->province }} , {{ $employee->zipCode }}</span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">Contact Number:</label>
                  <span class="col-md-9">{{ $employee->contactNumber }}</span>
                </div>
                <br />
                <div class = "form-group">
                  <label class="control-label col-md-3">In Case of Emergency:</label>
                  <div class="col-md-9">
                    <textarea class="form-control" style="height: 150px;">{{ $employee->inCaseOfEmergency }}</textarea>
                  </div>
                </div>
              </div>
              <div class = "col-md-3">

              </div>
            </div>
            <div class="row">
              <h4>Employee Roles</h4>
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
          </div>
        </div>
        <div id="menu1" class="tab-pane fade">
          <div class="col-md-12">
            <br />
            <div class="row">
              <div class="col-md-8">

              </div>
              <div class="col-md-4">
                <button class="btn but btn-md new_incident" type="button" style="width: 100%;">New Incident</button>
              </div>
            </div>
            <br />
            <div class="row">
              <table class="table tabl-responsive table-striped table-bordered cell-border" style="width: 100%;" id = "incident_table">
                <thead>
                  <tr>
                    <td>
                      Date
                    </td>
                    <td>
                      Date Closed
                    </td>
                    <td>
                      Actions
                    </td>
                  </tr>
                </thead>
                <tbody>
                  @forelse($employee_incidents as $emp_inc)
                  <tr>
                    <td>
                      {{ Carbon\Carbon::parse($emp_inc->date_opened)->toFormattedDateString() }}
                    </td>
                    <td>
                      {{ Carbon\Carbon::parse($emp_inc->date_opened)->toFormattedDateString() }}
                    </td>
                    <td>
                      <button class = 'btn btn-info view_delivery' title = 'View'><span class = 'fa fa-eye'></span></button>
                      <button class = 'btn btn-primary edit_delivery' title = 'Edit'><span class = 'fa fa-edit'></span></button>
                      <button class = 'btn but select-delivery' data-toggle = 'modal' data-target = '#deliveryModal' title = 'Status'><span class = 'fa-flag-o fa'></span></button>
                    </td>
                  </tr>
                  @empty

                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div id="menu2" class="tab-pane fade">
          <div class="col-md-12">
            <br />
            <div class="row">
              <div class="col-md-8">

              </div>
              <div class="col-md-4">
                <button class="btn but btn-md" type="button" style="width: 100%;">New Accident</button>
              </div>
            </div>
            <br />
            <div class="row">
              <table class="table tabl-responsive table-striped table-bordered cell-border" style="width: 100%;" id = "accident_table">
                <thead>
                  <tr>
                    <td>
                      Date
                    </td>
                    <td>
                      Date Closed
                    </td>
                    <td>
                      Actions
                    </td>
                  </tr>
                </thead>
                <tbody>
                 @forelse($employee_accidents as $emp_acc)
                 <tr>
                  <td>
                    {{ Carbon\Carbon::parse($emp_acc->date_opened)->toFormattedDateString() }}
                  </td>
                  <td>
                    {{ Carbon\Carbon::parse($emp_acc->date_closed)->toFormattedDateString() }}
                  </td>
                  <td>
                    <button class=""></button>
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

    <div class = "col-md-12">
      <form class = "">
        {{ csrf_field() }}

      </form>
    </div>
  </div>
</div>
</div>
@endsection

@push('styles')
<style type="text/css">
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
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '.new_incident', function(e){
      e.preventDefault();
      window.location.href = "{{ route('employees.index') }}/{{ $employee->id }}/incidents/create";
    })
    $('#incident_table').DataTable();

    $('#accident_table').DataTable();
  })
</script>
@endpush
