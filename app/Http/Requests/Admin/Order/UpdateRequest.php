<?php

namespace App\Http\Requests\Admin\Order;

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
use App\Enums\Order\StatusEnum;
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
            'address_first_name' => ['required', 'string', 'max:255'],
            'address_last_name' => ['required', 'string', 'max:255'],
            'address_company_name' => ['nullable', 'string', 'max:255'],
            'address_address' => ['required', 'string', 'max:255'],
            'address_city' => ['required', 'string', 'max:255'],
            'address_zipcode' => ['required', 'string', 'max:255'],
            'address_phone' => ['required', 'string', 'max:255'],

            'billing_first_name' => ['required', 'string', 'max:255'],
            'billing_last_name' => ['required', 'string', 'max:255'],
            'billing_company_name' => ['nullable', 'string', 'max:255'],
            'billing_address' => ['required', 'string', 'max:255'],
            'billing_city' => ['required', 'string', 'max:255'],
            'billing_zipcode' => ['required', 'string', 'max:255'],
            'billing_phone' => ['required', 'string', 'max:255'],
            'billing_email' => ['required', 'email', 'max:255'],
            'billing_nip' => ['required', 'string', 'max:255'],
            
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer'],
            'unavailable' => ['required', 'array'],
            'unavailable.*' => ['required'],
            'deleted' => ['required', 'array'],
            'deleted.*' => ['required'],

            'delivery' => ['required', Rule::in(DeliveryEnum::getValues())],
            'payment' => ['required', Rule::in(PaymentEnum::getValues())],

            'status' => ['required', Rule::in(StatusEnum::getValues())],

            'admin_comment' => ['sometimes', 'nullable', 'string'],
            'client_comment' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
