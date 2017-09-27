<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrokerageNonContainerDetails extends Model
{
  protected $fillable = [
  'descriptionOfGoods', 'grossWeight', 'supplier', 'lclType_id', 'brok_head_id',	
  ];
  public $timestamps = false;
    //
}
