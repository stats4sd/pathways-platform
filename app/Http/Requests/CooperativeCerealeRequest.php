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
            'village_id' => 'nullable|integer|exists:villages,id',
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
