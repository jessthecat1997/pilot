<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreUtility extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'bank_charges' => 'required|max:100|min:0',
            'other_charges' => 'required|max:100|min:0',
            'vat_rate' =>'required|max:100|min:0',
            'logo' => 'nullable|image|mimes:jpeg,bmp,png'
        ];
    }

    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
