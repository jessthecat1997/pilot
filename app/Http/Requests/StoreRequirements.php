<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
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
            'name' => 'required| max:50|regex:/^[\p{L}\p{N} .-]+$/|unique:requirements,name',
           
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required| max:50|min:3|regex:/^[\p{L}\p{N} .-]+$/|unique:requirements,name,'. $this->segment(3) ,
           
            ];

            break;
            
            default: break;
        }
    }
     public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
