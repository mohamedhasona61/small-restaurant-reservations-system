<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use App\Http\Requests\Api\BaseFormRequest;
class MenuCategoryRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,png,jpeg,webp',
        ];
        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|max:255|unique:menu_categories';
        }
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_categories')->ignore($this->route('menu_category'))
            ];
            $rules['old_images'] = [
                'old_images' => 'nullable|array',
                'old_images.*' => 'string',
            ];
        }
        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required',
            'name.unique' => 'This category name is already in use',
        ];
    }
}
