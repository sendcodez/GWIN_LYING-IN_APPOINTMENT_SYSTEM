<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;
    protected $table = 'doctor_availabilities';

    protected $fillable = [
        'doctor_id',
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
    public function doctor_services()
    {
        return $this->belongsTo(Doctor_service::class);
    }
}
