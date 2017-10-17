<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
	
	use SoftDeletes;
    public $incrementing = false;
    
	protected $primaryKey = 'plateNumber';
	
    protected $fillable = [
    	'vehicle_types_id',
    	'plateNumber',
    	'model',
    	'dateRegistered',
        'bodyType',
    ];
    protected $dates = [
    	'deleted_at',
    ];

    public function vehicle_type(){
        return $this->belongsTo('App\VehicleType', 'vehicle_types_id');
    }
}
