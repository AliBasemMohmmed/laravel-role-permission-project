<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'national_id_image' => 'required|image|max:2048',
            'patient_age' => 'required|integer',
            'prescription_number' => 'required|string|max:255',
            'dispensation_date' => 'required|date',
            'medication' => 'required|array',
            'medication.*' => 'required|string|max:255',
            'time' => 'required|array',
            'time.*' => 'required',
            'eating' => 'required|array',
            'eating.*' => 'required',
            'dosage_frequency' => 'required|array',
            'dosage_frequency.*' => 'required|integer',
        ];
    }
}
