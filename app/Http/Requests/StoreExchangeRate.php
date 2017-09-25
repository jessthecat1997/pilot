<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreExchangeRate extends FormRequest
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
        'rate'          => 'required|between:0,1000000|numeric',
        'dateEffective' => 'required|unique:exchange_rates|date',

        ];

        break;

        case 'PUT':
        
        return [
        'rate'         => 'required|between:0,1000000',
        'dateEffective' => 'required|date|unique:exchange_rates,dateEffective,' . $this->segment(3),
    
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
