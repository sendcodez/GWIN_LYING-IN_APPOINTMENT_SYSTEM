<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'doctor_id',
        'service_id',
        'date',
        'day',
        'start_time',
        'end_time',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function patients()
{
    return $this->belongsTo(Patient::class);
}
    
}
