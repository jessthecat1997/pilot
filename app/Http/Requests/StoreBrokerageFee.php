<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class StoreBrokerageFee extends FormRequest
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

                'dateEffective' => 'required|date|unique:brokerage_fee_headers,dateEffective',
                //'locations_id' => 'required|unique:arrastre_headers,locations_id',

            ];
            break;
            
            case 'PUT':

            return [


                'dateEffective' => 'required|date|unique:brokerage_fee_headers,dateEffective,' . $this->segment(3),

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
