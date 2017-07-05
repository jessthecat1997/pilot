<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeRole extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'employee_id', 'employee_type_id'
	];

	protected $dates = [
	'deleted_at',
	];

}
