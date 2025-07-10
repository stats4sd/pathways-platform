<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlotRequest extends FormRequest
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
            'field_id' => 'required',
            'numero_parcelle' => 'required',
            'nombre_arbre' => 'nullable',
            'fertilite' => 'nullable',
            'crop_id' => 'required',
            'cultures_associations' => 'nullable',
            'superficie_estimee' => 'nullable',
            'superficie_measuree' => 'nullable',
            'trace_superficie' => 'nullable',
            'prev_crop_id' => 'nullable',
            'nom_variete_culture' => 'nullable',
            'type_variete_culture' => 'nullable',
            'date_semence' => 'nullable',
            'quantite_semence' => 'nullable',
            'source_semence_culture' => 'nullable',
            'autre_source_semence_cutture' => 'nullable',
            'nom_arbres' => 'nullable',
            'quantite_fumure_organique' => 'nullable',
            'type_fumure_organique' => 'nullable',
            'autre_type_fumure_organique' => 'nullable',
            'quantite_npk' => 'nullable',
            'quantite_uree' => 'nullable',
            'nom_autre_engrais' => 'nullable',
            'observation_audio' => 'nullable',
            'observation_image' => 'nullable'
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
