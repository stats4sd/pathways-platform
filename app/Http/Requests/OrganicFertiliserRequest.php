<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganicFertiliserRequest extends FormRequest
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
            'quantite_fumure_organique' => 'nullable',
            'superficie_exploitation' => 'nullable',
            'protion_fertilisable' => 'nullable',
            'superficie_rotation' => 'nullable',
            'superficie_cycle' => 'nullable',
            'gap_annuel' => 'nullable',
            'gap_cycle' => 'nullable',
            'gap_cycle_pour100' => 'nullable',
            'nb_annee' => 'nullable',
            'observation_vocal' => 'nullable',
            'observation_video' => 'nullable',
            'observation_text' => 'nullable',
            'observation_image' => 'nullable',
            'appreciation_observation' => 'nullable',
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
