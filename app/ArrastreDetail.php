<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ArrastreDetail extends Model
{
	use SoftDeletes;
	protected $fillable = [
	'arrastre_header_id','container_sizes_id','amount',
	];

	protected $dates = [
	'deleted_at',
	];
    
}
