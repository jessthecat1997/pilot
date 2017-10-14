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

            'file_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg,doc,pdf,docx,zip|max:2048',
            'req_type_id' => 'required',
        ];
    }
}
