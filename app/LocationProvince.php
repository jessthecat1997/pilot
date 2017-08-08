<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
class LocationProvince extends Model
{
	use SoftDeletes;

    protected $fillable = [
    'name'
    ];

    protected $dates = [
    'deleted_at'
    ]
}
