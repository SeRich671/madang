<?php

namespace App\Http\Requests\Admin\User;

use App\Enums\User\RoleEnum;
use App\Enums\User\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => ['required', Rule::unique('users', 'email')->ignore($this->user->id)],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'status' => ['required', Rule::in(StatusEnum::getValues())],
            'role' => ['required', Rule::in(RoleEnum::getValues())],
            'branch_id' => ['required', 'exists:branches,id'],
            'uncertain' => ['sometimes', 'nullable', 'boolean'],
            'marketing' => ['sometimes', 'nullable', 'boolean'],

            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
