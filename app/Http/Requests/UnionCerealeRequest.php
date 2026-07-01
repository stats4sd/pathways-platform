<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnionCerealeRequest extends FormRequest
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
            'cercle_id' => 'nullable|integer|exists:cercles,id',
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
