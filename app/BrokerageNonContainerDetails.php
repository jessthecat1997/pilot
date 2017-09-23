<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrokerageNonContainerDetails extends Model
{
  protected $fillable = [
  'descriptionOfGoods', 'grossWeight', 'supplier', 'brok_head_id',	
  ];
  public $timestamps = false;
    //
}
