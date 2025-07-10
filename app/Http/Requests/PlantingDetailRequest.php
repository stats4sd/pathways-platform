<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantingDetailRequest extends FormRequest
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
            'planting_id' => 'required',
            'crop_id' => 'required',
            'superficie_ha' => 'nullable',
            'culture_prev' => 'nullable',
            'quantite_fumure_organique' => 'nullable',
            'cout_transport' => 'nullable',
            'quantite_chaux_agricole' => 'nullable',
            'cout_chaux_agricole' => 'nullable',
            'quantite_pnt_png' => 'nullable',
            'cout_pnt_png' => 'nullable',
            'superficie_labouree' => 'nullable',
            'cout_superficie_labouree' => 'nullable',
            'date_semence' => 'nullable',
            'quantite_semence' => 'nullable',
            'quantite_semence_achetee' => 'nullable',
            'cout_semence_achetee' => 'nullable',
            'quantite_herbicide_prelevee' => 'nullable',
            'cout_herbicide_prelevee' => 'nullable',
            'cout' => 'nullable',
            'observation_audio' => 'nullable',
            'observation_videos' => 'nullable',
            'observation_texte' => 'nullable',
            'observation_image' => 'nullable',
            'observation_appreciation' => 'nullable'
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
