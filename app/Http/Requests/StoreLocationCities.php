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
            'name' => 'required|min:3|regex:/^[\p{L}\p{N} .-]+$/|max:50|',
            'provinces_id' =>'required',
            
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required|min:3|regex:/^[\p{L}\p{N} .-]+$/|max:50|',
            'provinces_id' =>'required',
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