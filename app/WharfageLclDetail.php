<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class WharfageLclDetail extends Model
{
    use SoftDeletes;
	protected $fillable = [
	'wharfage_lcl_headers_id','basis_types_id','amount',
	];

	protected $dates = [
	'deleted_at',
	];
}
