<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreConsignee extends FormRequest
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
        'firstName' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'lastName' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'email' => 'required| unique:consignees',
        'address' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        ];

        break;

        case 'PUT':
        return [
        'vehicle_types_id' => 'required',
        'plateNumber' => 'required| max:20|min:2|unique:vehicles',
        'model' => 'required| max:20|min:2|regex:/^[\p{L}\p{N} .-]+$/',
        'dateRegistered' => 'required',
        ];

        break;
        
        default: break;
    }

    //Overriding the response 422
    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
