<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StandardAreaRate extends Model
{
  use SoftDeletes;

	protected $fillable = [
		'areaTo', 'areaFrom', 'amount',
	];

	protected $dates = [
		'deleted_at',
	];  
}
