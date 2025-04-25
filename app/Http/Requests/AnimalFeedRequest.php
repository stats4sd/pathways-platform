<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalFeedRequest extends FormRequest
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
            'total_concentre' => 'nullable',
            'total_residu' => 'nullable',
            'total_fane' => 'nullable',
            'liste_cat_animales' => 'nullable',
            'quantite_son' => 'nullable',
            'quantite_tourteau' => 'nullable',
            'concentre_produit' => 'nullable',
            'achat_son_quantite' => 'nullable',
            'prix_sac_son' => 'nullable',
            'cal_depense_son' => 'nullable',
            'prix_sac_tourteau' => 'nullable',
            'cal_depense_tourteau' => 'nullable',
            'cal_superficie' => 'nullable',
            'cal_depense_total' => 'nullable',
            'cal_depense_soins' => 'nullable',
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
