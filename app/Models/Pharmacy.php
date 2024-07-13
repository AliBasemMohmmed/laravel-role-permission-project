<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = [
        'name',
        'location',
        'logo',
        'user_id', // يجب تضمين user_id هنا
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
