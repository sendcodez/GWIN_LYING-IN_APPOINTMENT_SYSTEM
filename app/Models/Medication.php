<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'service_id',
        'appointment_id',
        'name',
        'date',
        'bed',
        'room',
        'date',
        'medications',
       
    ];
    protected $casts = [
        'medications' => 'array',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'user_id', 'user_id');
    }
}
