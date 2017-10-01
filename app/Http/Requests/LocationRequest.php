<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class LocationRequest extends FormRequest
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
            'name' => 'required| max:50|regex:/^[\p{L}\p{N} .-]+$/|unique:locations,name',
            'address' => 'required',
            'cities_id' => 'required',
            'zipCode' => 'required',
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required| max:50|min:3|regex:/^[\p{L}\p{N} .-]+$/|unique:locations,name,' . $this->segment(2),
            'address' => 'required',
            'cities_id' => 'required',
            'zipCode' => 'required',
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
