<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractAmendment extends Model
{
    protected $fillable = [
    'amendment', 'contract_headers_id',
    ];
}
