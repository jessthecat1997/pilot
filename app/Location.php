<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
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
