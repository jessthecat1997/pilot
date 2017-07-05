<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class StoreContainerType extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'description' => 'required| max:45',
        ];
    }

    //Overriding the response 422
    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
