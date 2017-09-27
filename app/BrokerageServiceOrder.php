<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BrokerageServiceOrder extends Model
{
    use SoftDeletes;

    public $timestamps = false;

  protected $fillable = [
     'shipper', 'expectedArrivalDate' , 'arrivalArea', 'freightType', 'freightBillNo', 'Weight', 'statusType', 'cargo_type', 'basis', 'withCO', 'consigneeSODetails_id', 'bi_head_id_rev', 'bi_head_id_exp'
  ];

	protected $dates = [
	'deleted_at',
	];
}
