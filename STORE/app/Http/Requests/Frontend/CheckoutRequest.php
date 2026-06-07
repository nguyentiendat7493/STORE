<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'address_id' => ['nullable', 'integer', 'exists:user_addresses,id'],
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string'],
            'shipping_method' => ['nullable', 'exists:shipping_methods,code'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
            'payment_method' => ['required', 'in:cod,bank_transfer,momo,vnpay', 'exists:payment_methods,code'],
        ];
    }
}
