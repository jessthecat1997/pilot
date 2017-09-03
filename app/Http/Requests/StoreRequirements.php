<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequirements extends FormRequest
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
            'name' => 'required| max:50|min:3|regex:/^[\p{L}\p{N} .-]+$/|unique:service_order_types,name',
            'description' => 'max:150'
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required| max:50|min:3|regex:/^[\p{L}\p{N} .-]+$/|unique:service_order_types,name,'. $this->segment(3) ,
            'description' => 'max:150'
            ];

            break;
            
            default: break;
        }
    }
}
