<?php

namespace App\Http\Requests\Api;


class PaymentRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'payment_option' => 'required|in:option1,option2',

        ];
    }

    public function messages()
    {
        return [
            'payment_option.required' => 'Payment option is required',
            'payment_option.in' => 'Payment option must be either option1 or option2',
        ];
    }
}
