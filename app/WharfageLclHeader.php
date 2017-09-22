<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class WharfageLclHeader extends Model
{
    use SoftDeletes;
	protected $fillable = [
	'locations_id','dateEffective',
	];

	protected $dates = [
	'deleted_at',
	];
}
