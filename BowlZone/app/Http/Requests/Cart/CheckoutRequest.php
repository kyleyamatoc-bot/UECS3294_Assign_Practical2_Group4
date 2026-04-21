<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'regex:/^\d{10,11}$/'],
            'payment_method' => ['required', 'in:Credit/Debit Card,FPX Online Banking,E-Wallet'],
            'card_number' => ['required_if:payment_method,Credit/Debit Card', 'nullable', 'digits:16'],
            'bank' => ['required_if:payment_method,FPX Online Banking', 'nullable', 'string', 'max:40'],
            'wallet_phone' => ['required_if:payment_method,E-Wallet', 'nullable', 'regex:/^\d{10,11}$/'],
        ];
    }
}
