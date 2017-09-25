<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportProcessingFeeHeader extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'dateEffective',
	];

	protected $dates = [
   		'deleted_at',
   	];
}
