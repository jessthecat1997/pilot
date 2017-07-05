<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrokerageFee extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'minimum', 'maximum', 'amount',
	];

	protected $dates = [
	'deleted_at',
	];

}
