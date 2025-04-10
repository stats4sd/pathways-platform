<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HumanCerealNeedRequest extends FormRequest
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
            'type_menage' => 'nullable',
            'personnes_nourri' => 'nullable',
            'besoin_cereale_exploitation' => 'nullable',
            'sac_mais' => 'nullable',
            'sac_mil' => 'nullable',
            'sac_sorgho' => 'nullable',
            'sac_cereales' => 'nullable',
            'sac_cereales_diff' => 'nullable',
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
