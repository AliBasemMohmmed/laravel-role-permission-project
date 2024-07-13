<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'prescription_id', 'medication_name', 'time', 'dosage_frequency','eating'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
