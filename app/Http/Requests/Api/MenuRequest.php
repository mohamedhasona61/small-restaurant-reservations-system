<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class MenuRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'daily_availability' => ['required', 'integer', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_type' => ['required_with:discount_amount', Rule::in(['percentage', 'fixed'])],
            'discount_start_at' => ['nullable', 'date', 'date_format:Y-m-d'],
            'discount_end_at' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:discount_start_at'],
            'is_active' => ['boolean'],
            'category_id' => ['required', 'exists:menu_categories,id'],
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp',
        ];
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            return array_map(fn($rule) => is_array($rule) ? array_merge(['sometimes'], $rule) : ['sometimes', $rule], $rules);
        }
        return $rules;
    }
}
