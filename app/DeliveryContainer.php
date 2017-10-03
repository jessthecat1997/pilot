<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryContainer extends Model
{
	use SoftDeletes;

    protected $fillable = [
    'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'remarks', 'del_head_id', 'shippingLine', 'portOfCfsLocation',
    ];
    protected $dates = [
    'deleted_at',
    ];
}
