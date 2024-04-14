<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'service_id',
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
}
