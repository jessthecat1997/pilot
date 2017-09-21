<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeIncident extends Model
{
    use SoftDeletes;

    private $fillable = [
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

    private $dates = [
    'deleted_at',
    ];

}