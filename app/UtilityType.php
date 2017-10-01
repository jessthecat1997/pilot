<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UtilityType extends Model
{
    protected $fillable = [
	'contract_template', 'quotation_template', 'bank_charges', 'other_charges'
	];

	
}
