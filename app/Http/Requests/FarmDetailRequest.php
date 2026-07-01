<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmDetailRequest extends FormRequest
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
            'phone_number' => 'nullable',
            
            'type' => 'nullable',
            'ratio_membre_terre' => 'nullable',
            'ratio_actif_terre' => 'nullable',
            'ratio_boeuflabour_terre' => 'nullable',

            'village_id' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'altitude' => 'nullable',
            'accuracy' => 'nullable',
            'chef_upa' => 'nullable',
            'gender_chef' => 'nullable',
            'age_chef' => 'nullable',
            'chef_travaux' => 'nullable',
            'neo_alphabete' => 'nullable',

            'activite_primaire' => 'nullable',
            'activite_secondaire' => 'nullable',
            'cereales_favoris_1' => 'nullable',
            'cereales_favoris_2' => 'nullable',
            'cereales_favoris_3' => 'nullable',
            'superficie_possede_upa' => 'nullable',
            'superficie_cultive_upa' => 'nullable',
            'nom_coop_coton_upa' => 'nullable',
            'nom_coop_cereales_upa' => 'nullable',
            'cooperative_cereale_id' => 'nullable|integer|exists:cooperative_cereales,id',
            'nom_union_cereales_upa' => 'nullable',
            'union_cereale_id' => 'nullable|integer|exists:union_cereales,id',
            'federation_scpc_id' => 'nullable|integer|exists:federation_scpcs,id',
            'union_scpc_id' => 'nullable|integer|exists:union_scpcs,id',
            'base_scpc_id' => 'nullable|integer|exists:base_scpcs,id',
            'upa_membres' => 'nullable',
            'upa_actifs' => 'nullable',
            'nombre_enfants' => 'nullable',
            'nombre_adolescents' => 'nullable',
            'nombre_femmes' => 'nullable',
            'nombre_hommes' => 'nullable',
            'nombre_femmes_agees' => 'nullable',
            'nombre_hommes_ages' => 'nullable',
            'nombre_charrues' => 'nullable',
            'nombre_multiculteurs' => 'nullable',
            'nombre_charrettes' => 'nullable',
            'nombre_tracteur' => 'nullable',
            'nombre_semoir' => 'nullable',
            'nombre_motoculteurs' => 'nullable',
            'nombre_pompe_traitement' => 'nullable',
            'nombre_pulverisateurs' => 'nullable',
            'nombre_corps_buteur' => 'nullable',
            'autre_materiel' => 'nullable',
            'nombre_autre_materiel' => 'nullable',
            'nombre_boeuf_labour' => 'nullable',
            'nombre_taureaux' => 'nullable',
            'nombre_vaches_taries' => 'nullable',
            'nombre_vaches_laitieres' => 'nullable',
            'nombre_genisses' => 'nullable',
            'nombre_veaux' => 'nullable',
            'nombre_anes' => 'nullable',
            'nombre_chevaux' => 'nullable',
            'nombre_moutons' => 'nullable',
            'nombre_chevres' => 'nullable',
            'nombre_porcs' => 'nullable',
            'nombre_poules' => 'nullable',
            'nombre_pintades' => 'nullable',
            'nombre_lapins' => 'nullable',
            'nombre_canards' => 'nullable',
            'nombre_pigeons' => 'nullable',
            'autre_animal' => 'nullable',
            'nombre_autre_animal' => 'nullable',
            'info_text' => 'nullable',
            'info_audio' => 'nullable',
            'info_image' => 'nullable',
            'info_video' => 'nullable',
            'observation_appreciation'
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
