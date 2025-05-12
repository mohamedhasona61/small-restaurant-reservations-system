<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors()->all());
        throw new ValidationException($validator, response()->json([
            'success' => false,
            'message' => __('Validation Error'),
            'errors' => $errors,
        ], 422));
    }
}
