<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrokerageContainer extends Model
{
  protected $fillable = [
  'containerNumber', 'containerVolume', 'containerReturnTo', 'containerReturnAddress', 'containerReturnDate', 'containerReturnStatus', 'dateReturned', 'remarks', 'brok_so_id', 'shippingLine', 'portOfCfsLocation',
  ];
  public $timestamps = false;
    //
}
