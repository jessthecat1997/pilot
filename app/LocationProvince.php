<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LocationProvince extends Model
{
	use SoftDeletes;

    protected $fillable = [
    'name',
    ];

    protected $dates = [
    'deleted_at',
    ];
}
