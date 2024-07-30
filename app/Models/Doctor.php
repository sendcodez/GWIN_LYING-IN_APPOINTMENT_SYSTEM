<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'user_id',
        'firstname',
        'middlename',
        'lastname',
        'contact_no',
        'address',
        'expertise',
        'description',
        'email',
        'password',
        'usertype',
        'status',
        'image',
    ];
    public function availabilities()
    {
        return $this->hasMany(DoctorAvailability::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function services()
{
    return $this->belongsToMany(Service::class, 'doctor_services');
}
public function patient()
{
    return $this->belongsTo(Patient::class);
}
public function rest_days()
{
    return $this->hasMany(RestDay::class);
}
public function availability()
    {
        return $this->hasMany(DoctorAvailability::class);
    }
    public function restDays()
    {
        return $this->hasMany(RestDay::class);
    }
}

