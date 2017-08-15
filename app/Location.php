<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
	'name',
	'address',
	'zipCode',
	'cities_id',
	];

	protected $dates = [
	'deleted_at',
	];
}
