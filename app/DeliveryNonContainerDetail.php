<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNonContainerDetail extends Model
{
    protected $fillable = [
    'descriptionOfGoods', 'grossWeight', 'supplier', 'del_head_id',	
    ];
    public $timestamps = false;
}
