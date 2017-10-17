<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreLocationCities extends FormRequest
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
            'name' => 'min:3|regex:/^[\p{L}\p{N} .-]+$/|max:50|unique:location_cities,name,
            provinces_id',
            
            'provincename' => 'unique:location_provinces,name|min:3|regex:/^[\p{L}\p{N} .-]+$/',
            
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'min:3|regex:/^[\p{L}\p{N} .-]+$/|max:50|unique:location_cities,name,' . $this->segment(4),
           'provincename' => 'unique:location_provinces,name|min:3|regex:/^[\p{L}\p{N} .-]+$/',
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