<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class FarmerLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'scan qr code / Cikɛda numerɔ kunafoni ta ni kamera ye',
            'phone_number.required' => 'enter phone number / Cikɛda talefone numerɔ don',
        ];
    }
}
