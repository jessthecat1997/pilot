<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Item extends Model
{
     use SoftDeletes;

	protected $fillable = [
	'name', 'hsCode', 'rate', 'sections_id', 'category_types_id',
	];

	protected $dates = [
	'deleted_at',
	];
}
