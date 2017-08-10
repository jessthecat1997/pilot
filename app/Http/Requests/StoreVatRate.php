<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
class StoreVatRate extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'fee' => 'required|numeric',
        'dateEffective' => 'required|unique:vat_rates',
        ];
    }

    public function response(array $errors)
    {
        return Response::make(json_encode($errors), 200);
    }
}
