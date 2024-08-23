<?php

// app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // Allow mass assignment for these attributes
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        // Add any other attributes you need to be mass assignable
    ];

    // Add relationships, casts, and other model-specific logic here
    public function patient()
{
    return $this->belongsTo(User::class, 'patient_id');
}
}
