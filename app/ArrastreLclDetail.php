<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ArrastreLclDetail extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'arrastre_header_id','lcl_types_id','basis_types_id','amount',
	];

	protected $dates = [
		'deleted_at',
	];
}
