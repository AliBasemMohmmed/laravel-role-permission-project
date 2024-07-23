<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'working_days',
        'vacation_days',
        'daily_patient_limit',
        'user_id',
    ];

    protected $casts = [
        'working_days' => 'array',
        'vacation_days' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
