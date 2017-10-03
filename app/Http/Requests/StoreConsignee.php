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
        'companyName' =>'required',
        'firstName' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'lastName' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'email' => 'required| unique:consignees',
        'address' => 'required|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'contactNumber' => 'required',
        'businessStyle' =>'required',
        'city'  =>'required',
        'st_prov'  =>'required',
        'zip'  =>'required| max:5',
        'b_address'  =>'required',
        'b_city'  =>'required',
        'b_st_prov'  =>'required',
        'b_zip' =>'required',

        ];

        break;

        case 'PUT':
        return [
        'companyName' =>'required',
        'firstName' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'lastName' => 'required| max:45|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'email' => 'required| unique:consignees',
        'address' => 'required|min:1|regex:/^[\p{L}\p{N} .-]+$/',
        'contactNumber' => 'required',
        'businessStyle' =>'required',
        'city'  =>'required',
        'st_prov'  =>'required',
        'zip'  =>'required| max:5',
        'b_address'  =>'required',
        'b_city'  =>'required',
        'b_st_prov'  =>'required',
        'b_zip' =>'required',

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
