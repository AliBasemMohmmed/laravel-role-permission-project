<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Reservation.php
public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}

public function patient()
{
    return $this->belongsTo(User::class, 'patient_id');
}

}
