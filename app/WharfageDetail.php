<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class WharfageDetail extends Model
{
   use SoftDeletes;
	protected $fillable = [
	'wharfage_header_id','container_sizes_id','amount',
	];

	protected $dates = [
	'deleted_at',
	];
}
