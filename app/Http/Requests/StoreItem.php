<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreItem extends FormRequest
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
                'name' => 'required| max:50|regex:/^[\p{L}\p{N} .-]+$/|unique:category_types,name',
                'sections_id' =>'required',
                'category_types_id' => 'required',

            ];

            break;

            case 'PUT':

            return [
                'name' => 'required| max:50|min:3|regex:/^[\p{L}\p{N} .-]+$/|unique:category_types,name,'. $this->segment(3) ,
                'sections_id' =>'required',
                'category_types_id' => 'required',


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
