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
            'address' => ['required', 'array'],
            'address.first_name' => ['required', 'string', 'max:255'],
            'address.last_name' => ['required', 'string', 'max:255'],
            'address.company_name' => ['nullable', 'string', 'max:255'],
            'address.address' => ['required', 'string', 'max:255'],
            'address.city' => ['required', 'string', 'max:255'],
            'address.zipcode' => ['required', 'string', 'max:255'],
            'address.phone' => ['required', 'string', 'max:255'],

            'billing' => ['required', 'array'],
            'billing.first_name' => ['required', 'string', 'max:255'],
            'billing.last_name' => ['required', 'string', 'max:255'],
            'billing.company_name' => ['nullable', 'string', 'max:255'],
            'billing.address' => ['required', 'string', 'max:255'],
            'billing.city' => ['required', 'string', 'max:255'],
            'billing.zipcode' => ['required', 'string', 'max:255'],
            'billing.phone' => ['required', 'string', 'max:255'],
            'billing.email' => ['required', 'email', 'max:255'],
            'billing.nip' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'delivery' => ['required', 'array'],
            'payment' => ['required', 'array'],
            'delivery.*' => ['required', Rule::in(DeliveryEnum::getValues())],
            'payment.*' => ['required', Rule::in(PaymentEnum::getValues())],
        ];
    }
}
