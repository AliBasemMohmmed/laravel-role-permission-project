<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'working_days' => 'nullable|array',
            'working_days.*' => 'string',
            'vacation_days' => 'nullable|array',
            'vacation_days.*' => 'string',
            'daily_patient_limit' => 'nullable|integer',
        ];
    }
}
