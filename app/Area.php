<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
	// ETO YUNG SAMPLE CHANGES NI NEIL
	use SoftDeletes;

	protected $fillable = [
	'description',
	];
	//AAIS
	protected $dates = [
	'deleted_at',
	];
}
