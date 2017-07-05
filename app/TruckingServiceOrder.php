<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckingServiceOrder extends Model
{

    protected $fillable = [
    'deliveryDate', 'destination', 'shippingLine', 'portOfCfsLocation', 'status', 'so_details_id',
    ];

    protected $dates = [
    'deliveryDate', 
    ];
}
