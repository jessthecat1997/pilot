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
        return [

        'rate'          => 'required',
        'dateEffective' => 'required|unique:exchange_rates|date|before:tomorrow|',


        ];
    }

    //Overriding the response 422
    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
