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
            'concentre_produit' => 'nullable',
            'achat_sac_con_quanti' => 'nullable',
            'note_quant_achat' => 'nullable',
            'achat_sac_con_son' => 'nullable',
            'quantite_stourteau' => 'nullable',
            'quantite_sac_tourteau' => 'nullable',
            'prix_sac_son' => 'nullable',
            'cal_depense_son' => 'nullable',
            'prix_sac_tourteau' => 'nullable',
            'cal_depense_tour' => 'nullable',
            'cal_superficie' => 'nullable',
            'cal_depense_total' => 'nullable',
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
