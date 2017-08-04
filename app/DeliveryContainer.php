<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryContainer extends Model
{
    protected $fillable = [
    'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'remarks', 'del_head_id', 'shippingLine', 'portOfCfsLocation',
    ];
    public $timestamps = false;
}
