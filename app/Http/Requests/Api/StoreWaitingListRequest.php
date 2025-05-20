<?php

namespace App\Http\Requests\Api;


class StoreWaitingListRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'guest_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'table_id' => 'nullable|exists:tables,id',
        ];
    }
}
