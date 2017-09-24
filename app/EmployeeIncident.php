<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeIncident extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'incident_date',
    'incident_time',
    'date_opened',
    'date_closed',
    'address',
    'cities_id',
    'delivery_id',
    'fine',
    'description',
    ];

    protected $dates = [
    'deleted_at',
    'date_opened',
    'date_closed',

    ];

}