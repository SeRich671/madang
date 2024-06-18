<?php

namespace App\Http\Requests\Contact;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'attachment' => ['sometimes', 'nullable', 'file', 'mimes:pdf,jpeg,png,gif'],
            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }
}
