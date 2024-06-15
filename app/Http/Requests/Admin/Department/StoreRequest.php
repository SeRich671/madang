<?php

namespace App\Http\Requests\Admin\Department;

use App\Enums\Department\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'string'],
            'image' => ['required', 'image'],
            'subdomain' => ['required', 'string'],
            'status' => ['required', Rule::in(StatusEnum::getValues())],
            'footer_auth' => ['sometimes', 'nullable', 'string'],
            'footer_guest' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
