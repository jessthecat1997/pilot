<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankCharges extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

 array
     */
    public function rules()
    {
        return [
            'bank_charges' => 'required',
        ];
    }
}
