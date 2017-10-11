<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreArrastreFeeLCL extends FormRequest
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

            'dateEffective' => 'required|date|unique:arrastre_lcl_headers,dateEffective',
            

            ];
            break;
            
            case 'PUT':

            return [

           
            'dateEffective' => 'required|date|unique:arrastre_lcl_headers,dateEffective,' . $this->segment(3),

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
