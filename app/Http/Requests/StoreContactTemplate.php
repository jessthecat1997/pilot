<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractTemplate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'description' => 'max:500|required'
            ];

            break;
            
            case 'PUT':

            return [
            'name' => 'required| unique:contract_templates,name,'. $this->segment(3) ,
            'description' => 'max:500|required|unique:contract_templates,description,'. $this->segment(3),
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
