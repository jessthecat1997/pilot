<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brokerage_status_type extends Model
{
	use SoftDeletes;

    protected $fillable = [
    'description',
    ];

    protected $dates = [
    'deleted_at',
    ];
}
