<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes;

	public function users()
	{
		return $this
		->belongsToMany('App\User')
		->withTimestamps();
	}
	protected $dates = [
	'deleted_at',
	];
}
