<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'firstName',
	'middleName',
	'lastName',
	'dob',
	'address',
	'zipCode',
	'cities_id',
	'SSSNo',
	'contactNumber',
	'inCaseOfEmergency',
	];

	protected $dates = [
	'deleted_at',
	];
}