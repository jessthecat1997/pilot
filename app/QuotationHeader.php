<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationHeader extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'consignees_id',
    'specificDetails',
    ];

    protected $dates = [
    'deleted_at',
    ];
}
