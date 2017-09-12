<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BasisType extends Model
{
	use SoftDeletes;

	protected $fillable = [
	'name', 'abbreviation'
	];

	protected $dates = [
	'deleted_at',
	];
    
}
