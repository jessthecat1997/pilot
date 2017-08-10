<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerType extends Model
{
    use SoftDeletes;

	protected $fillable = [
	'name', 'maxWeight', 'description' ,
	];

	protected $dates = [
	'deleted_at',
	];
}
