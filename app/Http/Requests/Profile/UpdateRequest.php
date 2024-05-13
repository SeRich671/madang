<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'company_name' => ['nullable', 'string'],
            'nip' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->user()->id],
            'phone' => ['required', 'string'],
            'company_address' => ['required', 'string'],
            'company_city' => ['required', 'string'],
            'company_zipcode' => ['required', 'string'],
            'company_fax' => ['nullable', 'string'],
            'marketing' => ['sometimes', 'nullable', 'in:0,1'],
            'password' => ['sometimes', 'nullable', 'min:8', 'confirmed'],
        ];
    }
}
