<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable|integer',
            'code' => 'nullable',
            'year' => 'nullable',
            'num_phone' => 'nullable',
            'chef_upa' => 'nullable',
            'chef_travaux' => 'nullable',
            'neo_alphabete' => 'nullable',
            'activite_primaire' => 'nullable',
            'activite_secondaire' => 'nullable',
            'cereales_favoris_1' => 'nullable',
            'cereales_favoris_2' => 'nullable',
            'cereales_favoris_3' => 'nullable',
            'superficie_possede_upa' => 'nullable',
            'superficie_cultive_upa' => 'nullable'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
