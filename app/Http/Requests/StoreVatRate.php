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
       switch ($this->method()) {
            case 'POST':

            return [

            'rate' => 'required|numeric|between:0,1000000',
            'dateEffective' => 'required|date|unique:vat_rates,dateEffective',

            ];
            break;
            
            case 'PUT':

            return [

            'rate' => 'required|numeric|between:0,1000000',
            'dateEffective' => 'required|date|unique:vat_rates,dateEffective,' . $this->segment(3),

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
