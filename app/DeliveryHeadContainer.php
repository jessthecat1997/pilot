<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryHeadContainer extends Model
{
    use SoftDeletes;

    protected $fillable = 
    [
    'del_head_id',
    'container_id',
    ];

    protected $dates = 
    [
   	'deleted_at',
    ];
}
