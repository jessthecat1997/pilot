<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class StoreVehicle extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       switch ($this->method()) {

        case 'POST':

        return [
        'vehicle_types_id' => 'required',
        'plateNumber' => 'required|max:20|min:2|unique:vehicles,plateNumber',
        'model' => 'required| max:20|min:2|regex:/^[\p{L}\p{N} .-]+$/',
        'dateRegistered' => 'required',
        ];

        break;

        case 'PUT':
        
        return [
        'vehicle_types_id' => 'required',
        'plateNumber' => 'required| max:20|min:2|unique:vehicles,plateNumber,'. $this->segment(4),
        'model' => 'required| max:20|min:2|regex:/^[\p{L}\p{N} .-]+$/',
        'dateRegistered' => 'required',
        ];

        break;
        
        default: break;
    }
}

 //Overriding the response 422
public function response(array $errors)
{
    return Response::make(json_encode($errors), 200);
}

}
