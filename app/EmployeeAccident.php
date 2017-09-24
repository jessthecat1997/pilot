<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAccident extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'incident_date',
	'incident_time',
	'date_opened',
	'date_closed',
	'address',
	'cities_id',
	'delivery_id',
	'numberOfInjuries',
	'numberOfFatalities',
	'propertyDamage',
	'description',
	];

	protected $dates = [
	'deleted_at',
	];
}
