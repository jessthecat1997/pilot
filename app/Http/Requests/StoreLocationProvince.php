<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class StoreLocationProvince extends FormRequest
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
            'name' => 'required|unique:location_provinces,name|min:3|regex:/^[\p{L}\p{N} .-]+$/|max:50|',
            
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required|min:3|regex:/^[\p{L}\p{N} .-]+$/|max:50|unique:location_provinces,name,'. $this->segment(3) ,
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