<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;


    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'date',
        'day',
        'start_time',
        'end_time',
    ];
}
