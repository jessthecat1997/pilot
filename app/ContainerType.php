<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerType extends Model
{
    use SoftDeletes;

	protected $fillable = [
	'name', 'length', 'width' , 'height' , 'description' ,
	];

	protected $dates = [
	'deleted_at',
	];
}
