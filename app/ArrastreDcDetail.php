<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ArrastreDcDetail extends Model
{
    use SoftDeletes;
	protected $fillable = [
	'arrastre_dc_headers_id','dc_types_id','container_sizes_id','amount',
	];

	protected $dates = [
	'deleted_at',
	];
}
