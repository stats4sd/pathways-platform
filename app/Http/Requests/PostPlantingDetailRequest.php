<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostPlantingDetailRequest extends FormRequest
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
            'post_planting_id' => 'required',
            'crop_id' => 'required',
            'superficie_sarclage' => 'nullable',
            'cout_sarclage' => 'nullable',
            'superficie_desherbage' => 'nullable',
            'cout_desherbage' => 'nullable',
            'quantite_npk' => 'nullable',
            'cout_npk' => 'nullable',
            'quantite_uree' => 'nullable',
            'cout_uree' => 'nullable',
            'quantite_herbicide' => 'nullable',
            'cout_herbicide' => 'nullable',
            'superficie_butee' => 'nullable',
            'cout_buttage' => 'nullable',
            'quantite_insecticide' => 'nullable',
            'cout_insecticide' => 'nullable',
            'cout' => 'nullable',
            'observation_audio' => 'nullable',
            'observation_video' => 'nullable',
            'observation_texte' => 'nullable',
            'observation_image' => 'nullable',
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
