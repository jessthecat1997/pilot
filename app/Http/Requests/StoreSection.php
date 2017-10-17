<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreSection extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
     switch ($this->method()) 
     {
        case 'POST':

        return [
            'name' => 'required|unique:sections,name',

        ];

        break;

        case 'PUT':

        return [
            'name' => 'required|unique:sections,name,'. $this->segment(3) ,

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
