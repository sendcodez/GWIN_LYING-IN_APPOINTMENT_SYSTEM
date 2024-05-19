<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'status',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function doctorsAppointments()
    {
        return $this->hasManyThrough(Doctor::class, Appointment::class);
    }
    
    public function doctorsServices()
    {
        return $this->belongsToMany(Doctor::class);
    }
    public function doctors()
{
    return $this->belongsToMany(Doctor::class, 'doctor_services');
}
    
}
