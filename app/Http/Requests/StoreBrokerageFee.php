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
        return [
        'minimum' => 'required|',
        'maximum' => 'required|',
        'amount' => 'required|',
        'dateEffective' =>'required|date|'
        ];
    }

    //Overriding the response 422
    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }

}
