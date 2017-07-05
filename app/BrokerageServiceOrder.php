<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BrokerageServiceOrder extends Model
{
    use SoftDeletes;

	protected $fillable = [
		 'expectedArrivalDate' , 'arrivalDate' , 'deposit' ,
		 'containerNumber' ,'statusType' ,'receiveTypeDescription' ,'awbType' ,'awb' ,'billOfLading' , 'vessel' ,'docking' ,'consigneeSODetails_id' ,
	];

	protected $dates = [
	'deleted_at',
	];
}
