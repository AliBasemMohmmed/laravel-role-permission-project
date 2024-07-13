<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_name', 'patient_name', 'national_id_image', 'patient_age', 'prescription_number', 'dispensation_date',
    ];

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
}
