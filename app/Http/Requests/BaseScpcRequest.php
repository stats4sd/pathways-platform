<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseScpcRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'id' => 'nullable|integer',
            'nom' => 'required',
            'villages' => 'nullable|array',
            'villages.*' => 'integer|exists:villages,id',
        ];
    }

    public function attributes()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }
}
