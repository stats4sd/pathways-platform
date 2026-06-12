<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FederationScpcRequest extends FormRequest
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
            'regions' => 'nullable|array',
            'regions.*' => 'integer|exists:regions,id',
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
