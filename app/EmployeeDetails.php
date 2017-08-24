<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDetails extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'employees_id', 'dateOfBirth', 'age', 'address', 'zipCode', 'cities_id', 'socialSecurityNumber', 'cellphoneContact', 'phoneContact', 'emergencyContact', 'inCaseOfEmergency'
  ];

  protected $dates = [
    'deleted_at',
  ];

    //
}
