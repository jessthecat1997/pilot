<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
	protected $fillable = [
	'com_name',
	'com_image',
	'com_owner_firstName',
	'com_owner_middleName',
	'com_owner_lastName',
	'com_address_roomUnitStall',
	'com_address_buildingFloor',
	'com_address_buildingName',
	'com_address_lotHouseNo',
	'com_address_street',
	'com_address_subdivision',
	'com_address_barangay',
	'com_address_province',
	'com_address_city',
	'com_address_zipCode'
	];
	
}
