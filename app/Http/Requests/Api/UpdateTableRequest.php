<?php

namespace App\Http\Requests\Api;


class UpdateTableRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'number' => 'sometimes|string|max:10|unique:tables,number,'.$this->table,
            'capacity' => 'sometimes|integer|min:1',
            'is_active' => 'sometimes|boolean'
        ];
    }
}
