<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VatRate extends Model
{
    use SoftDeletes;

	protected $fillable = [
	'description','rate','currentRate', 'dateEffective',
	];

	protected $dates = [
	'deleted_at',
	];
}
