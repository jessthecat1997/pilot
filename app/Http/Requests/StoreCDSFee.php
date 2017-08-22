<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class StoreCDSFee extends FormRequest
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

            'fee' => 'required|numeric',
            'dateEffective' => 'required|unique:cds_fees,dateEffective',

            ];
            break;
            
            case 'PUT':

            return [

            'fee' => 'required|numeric',
            'dateEffective' => 'required|unique:cds_fees,dateEffective,' . $this->segment(3),

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
