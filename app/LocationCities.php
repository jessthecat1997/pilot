<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LocationCities extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    'name', 'provinces_id',
    ];

    protected $dates = [
    'deleted_at',
    ];
}
