<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterestPointRequest extends FormRequest
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
            'nom' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'altitude' => 'nullable',
            'accuracy' => 'nullable',
            'description_audio' => 'nullable',
            'description_videos' => 'nullable',
            'description_image' => 'nullable',

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
