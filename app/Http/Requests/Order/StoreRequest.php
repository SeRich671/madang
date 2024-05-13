<?php

namespace App\Http\Requests\Order;

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'delivery' => ['required', 'array'],
            'payment' => ['required', 'array'],
            'delivery.*' => ['required', Rule::in(DeliveryEnum::getValues())],
            'payment.*' => ['required', Rule::in(PaymentEnum::getValues())],
        ];
    }
}
