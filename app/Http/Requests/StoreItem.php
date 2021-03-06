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
                'name' => 'required|unique:items,name',
                'sections_id' =>'required',
                'category_types_id' => 'required',
                'hsCode' => 'required|unique:items,hsCode',

            ];

            break;

            case 'PUT':

            return [
                'name' => 'required|unique:items,name,'. $this->segment(3) ,
                'sections_id' =>'required',
                'category_types_id' => 'required',
                'hsCode' => 'required|unique:items,name'


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
