@extends('layouts.app')
@section('content')
<div class = "col-md-12">
  <div class = "panel panel-default">
    <div class = "panel-heading">
      <h4>Employee <small><strong>{{ $employee->id }}</strong></small>.</h4>
    </div>
    <div class = "panel-body">
      <div class = "col-md-12">
        <form class = "">
          {{ csrf_field() }}
          <div class="row">
            <h4>Basic Information</h4>
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
        </form>
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
