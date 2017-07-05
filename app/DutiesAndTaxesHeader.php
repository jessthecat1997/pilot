<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DutiesAndTaxesHeader extends Model
{
    use SoftDeletes;

	protected $fillable = [
		'exchangeRate' ,'date' ,'brokerageServiceOrders_id' , 
		'employees_id_broker' ,
	];

	protected $dates = [
	'deleted_at',
	];
}
