<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmExpenseRequest extends FormRequest
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
            'farm_id' => 'required',
            'year' => 'nullable',
            'frais_condiment_annuel' => 'nullable',
            'frais_sante_annuel' => 'nullable',
            'frais_education_annuel' => 'nullable',
            'frais_aliment_betail' => 'nullable',
            'frais_veterinaire' => 'nullable',
            'autre_frais' => 'nullable',
            'montant_autre_frais' => 'nullable',
            'invest_maison' => 'nullable',
            'invest_mariage' => 'nullable',
            'autre_invest' => 'nullable',
            'montant_autre_invest' => 'nullable',
            'depenses_recurrentes' => 'nullable',
            'depenses_investissements' => 'nullable',
            'depenes_total' => 'nullable',
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
