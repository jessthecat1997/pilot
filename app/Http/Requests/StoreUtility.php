<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUtility extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'bank_charges' => 'required|max:100',
            'other_charges' => 'required:max:100',
        ];
    }
}
