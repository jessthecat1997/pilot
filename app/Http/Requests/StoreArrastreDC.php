<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreArrastreDC extends FormRequest
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

                'dateEffective' => 'required|date|unique:arrastre_headers,dateEffective',
                'locations_id' => 'required|unique:arrastre_headers,locations_id',

            ];
            break;
            
            case 'PUT':

            return [

                
                'dateEffective' => 'required|date|unique:arrastre_fees,dateEffective,' . $this->segment(3),

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
