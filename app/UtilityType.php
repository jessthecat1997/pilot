<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UtilityType extends Model
{
    protected $fillable = [
	'contract_template', 'quotation_template', 'bank_charges', 'other_charges','insurance_gc','insurance_c','company_logo','company_name','company_address','company_tin','company_contact','payment_allowance'
	];

	
}
