<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceOrderAttachments extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,bmp,svg,doc,pdf,docx,zip',
            'req_type_id' => 'required',
        ];
    }
}
