<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'firstName', 'middleName', 'lastName', 'employee_types_id',
    ];

    protected $dates = [
    	'deleted_at',
    ];
}
