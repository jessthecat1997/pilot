<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreConsignee extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'firstName' => 'required',
        'middleName' => 'nullable',
        'lastName' => 'required',

        ];
    }

    //Overriding the response 422
    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
