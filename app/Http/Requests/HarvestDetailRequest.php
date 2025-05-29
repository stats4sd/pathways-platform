<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HarvestDetailRequest extends FormRequest
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
            'harvest_id' => 'required',
            'crop_id' => 'required',
            'superficie_recolte_prestation' => 'nullable',
            'cout_total_prestation_recolte' => 'nullable',
            'production' => 'nullable',
            'cout_total_battage' => 'nullable',
            'production_residu_culture' => 'nullable',
            'nombre_botte' => 'nullable',
            'cout' => 'nullable',
            'observation_audio' => 'nullable',
            'observation_videos' => 'nullable',
            'observation_texte' => 'nullable',
            'observation_image' => 'nullable',
            'observation_appreciation' => 'nullable',
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
