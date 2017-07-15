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
        return [

        'fee' => 'required|numeric',
        'dateEffective' => 'required|unique:cds_fees',
      
        ];
    }


    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
