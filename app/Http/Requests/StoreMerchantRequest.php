<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMerchantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'business_name' => 'required|string',
            'address' => 'required|string',
            'region' => 'required|string',
            'digital_address' => 'required|string',
            'business_email' => 'required|email',
            'contact_person_name' => 'required|string',
            'contact_person_email' => 'required|email',
            'contact_person_phone' => ['required', 'phone:GH'],
            'is_live' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'contact_person_phone' => 'The phone number provided is invalid',
        ];
    }
}
