<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CategoryType extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name', 'description', 'sections_id',
	];

	protected $dates = [
		'deleted_at',
	];
}
