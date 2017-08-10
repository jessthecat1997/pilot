<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreContractTemplate extends FormRequest
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
            'name' => 'required|unique:contract_templates,name',
            'description' => 'max:1000|required|unique:contract_templates,description'
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required| unique:contract_templates,name,'. $this->segment(3) ,
            'description' => 'max:1000|required|unique:contract_templates,description,'. $this->segment(3),
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
