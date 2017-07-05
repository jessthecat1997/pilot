<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IpfFee extends Model
{
    use SoftDeletes;

	protected $fillable = [
	'minimum','maximum','amount',
	];

	protected $dates = [
	'deleted_at',
	];
}
