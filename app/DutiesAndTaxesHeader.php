<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DutiesAndTaxesHeader extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'exchangeRate_id', 'cdsFee_id', 'ipfFee_id', 'brokerageFee', 'arrastre', 'wharfage', 'bankCharges', 'brokerageServiceOrders_id' , 'employees_id_broker', 'statusType',
  	];

	protected $dates = [
	'deleted_at',
	];
}
