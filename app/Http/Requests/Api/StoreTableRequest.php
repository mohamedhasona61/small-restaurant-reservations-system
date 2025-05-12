<?php

namespace App\Http\Requests\Api;


class StoreTableRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'number' => 'required|string|max:255|unique:tables,number',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ];
    }
}
