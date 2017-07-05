<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRate extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'rate', 'description', 'currentRate', 'dateEffective',
    ];

    protected $dates = [
     'deleted_at', 
    ];

}
