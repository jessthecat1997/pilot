<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DutiesAndTaxesDetails extends Model
{
  use SoftDeletes;

	protected $fillable = [
		'descriptionOfGoods' , 'valueInUSD' , 'insurance' , 'freight' , 'otherCharges' , 'hsCode' ,'rateOfDuty' ,
		'dutiesAndTaxesHeaders_id',
	];

	protected $dates = [
	'deleted_at',
	];
}
