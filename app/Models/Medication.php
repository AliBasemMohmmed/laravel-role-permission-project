<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'prescription_id', 'product_id', 'time', 'dosage_frequency','eating'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
