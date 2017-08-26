<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class ConsigneeDeposit extends Model
{
    use softDeletes;

    protected $fillable = [
    'amount',
    'currentBalance',
    'description',
    'consignees_id'
    ];

    protected $dates = [
    'deleted_at',
    ];
}