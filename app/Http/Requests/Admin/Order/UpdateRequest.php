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
