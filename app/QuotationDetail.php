<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'locations_id_from',
    'locations_id_to',
    'amount',
    'quot_header_id'
    ];

    protected $dates = [
    'deleted_at'
    ];
}
