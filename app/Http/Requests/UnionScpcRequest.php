<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnionScpcRequest extends FormRequest
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
            'commune_id' => 'nullable|integer|exists:communes,id',
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
