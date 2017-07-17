<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'name', 'description'
	];

	protected $dates = [
	'deleted_at'
	];
}
