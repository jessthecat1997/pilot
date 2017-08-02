<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BrokerageServiceOrder extends Model
{
    use SoftDeletes;

    public $timestamps = false;

  protected $fillable = [
     'shipper', 'expectedArrivalDate' , 'arrivalArea', 'freightType', 'freightBillNo', 'Weight', 'statusType','consigneeSODetails_id' ,
  ];

	protected $dates = [
	'deleted_at',
	];
}
