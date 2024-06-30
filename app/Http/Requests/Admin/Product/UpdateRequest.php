<?php

namespace App\Http\Requests\Admin\Product;

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
            'name' => ['required', 'string'],
            'code' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'exists:categories,id'],
            'branches' => ['required', 'array'],
            'branches.*' => ['required', 'exists:branches,id'],
            'branch_id' => ['sometimes', 'nullable', 'exists:branches,id'],
            'price' => ['required', 'string'],
            'discount_price' => ['nullable', 'string'],
            'size_carton' => ['required', 'string'],
            'count_in_package' => ['required', 'string'],
//            'in_stock' => ['required', 'string'],
            'image' => ['sometimes', 'nullable', 'image'],
            'is_available' => ['required', 'boolean'],
            'is_recommended' => ['required', 'boolean'],
            'bought_by_others' => ['required', 'boolean'],
            'sticker' => ['required', 'boolean'],
            'later_delivery' => ['required', 'boolean'],

            'stickers' => ['sometimes', 'nullable', 'array'],
            'stickers.*' => ['sometimes', 'nullable', 'exists:products,id'],

            'attributes' => ['sometimes', 'nullable', 'array'],
            'attributes.*.attribute_id' => ['sometimes', 'nullable', 'exists:attributes,id'],
            'attributes.*.value' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
