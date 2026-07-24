<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CooperativeCerealeRequest extends FormRequest
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
            'union_cereale_id' => 'nullable|integer|exists:union_cereales,id',
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
