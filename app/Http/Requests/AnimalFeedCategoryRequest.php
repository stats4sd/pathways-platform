<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalFeedCategoryRequest extends FormRequest
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
            'animal_feed_id' => 'required',
            'categorie' => 'nullable',
            'nb_animaux' => 'nullable',
            'type_regime' => 'nullable',
            'comp_faible_con' => 'nullable',
            'comp_faible_resid' => 'nullable',
            'comp_faible_fane' => 'nullable',
            'comp_ameli_con' => 'nullable',
            'comp_ameli_resid' => 'nullable',
            'comp_ameli_fane' => 'nullable',
            'stabulation_con' => 'nullable',
            'stabulation_resid' => 'nullable',
            'stabulation_fane' => 'nullable',
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
