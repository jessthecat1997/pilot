<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ArrastreDcHeader extends Model
{
    use SoftDeletes;
	protected $fillable = [
	'locations_id',
	];

	protected $dates = [
	'deleted_at',
	];
}
