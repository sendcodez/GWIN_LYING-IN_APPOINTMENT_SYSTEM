<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patients'; // Specify custom table name

    protected $fillable = [
        'user_id',
        'firstname', 
        'middlename', 
        'lastname', 
        'maiden',
        'birthplace',
        'birthday',
        'age',
        'civil',
        'contact_number',
        'religion',
        'occupation',
        'nationality',
        'husband_firstname',
        'husband_middlename',
        'husband_lastname',
        'husband_occupation',
        'husband_birthday',
        'husband_age',
        'husband_contact_number',
        'husband_religion',
        'province',
        'city',
        'barangay',
        'husband_province',
        'husband_city',
        'husband_barangay',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pregnancyTerms()
    {
        return $this->hasMany(Pregnancy_term::class, 'user_id', 'user_id');
    }

    // Define the relationship with pregnancy histories
    public function pregnancyHistories()
    {
        return $this->hasMany(PregnancyHistory::class, 'user_id', 'user_id');
    }

    // Define the relationship with medical histories
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, 'user_id', 'user_id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id', 'user_id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'user_id', 'user_id');
    }

    public function laboratories()
    {
        return $this->hasMany(Laboratory::class, 'user_id', 'user_id');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'user_id', 'user_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id', 'user_id');
    }

    public function ultrasounds()
    {
        return $this->hasMany(Ultrasound::class, 'user_id', 'user_id');
    }
  
    public function medications()
    {
        return $this->hasMany(Medication::class, 'user_id', 'user_id');
    }
    public function delivery()
    {
        return $this->hasMany(Delivery::class, 'user_id', 'user_id');
    }
    public function newborn()
    {
        return $this->hasMany(Newborn::class, 'user_id', 'user_id');
    }
    public function postpartum()
    {
        return $this->hasMany(Postpartum::class, 'user_id', 'user_id');
    }
    public function labor()
    {
        return $this->hasMany(Labor::class, 'user_id', 'user_id');
    }
    public function staffnotes()
    {
        return $this->hasMany(Staffnotes::class, 'user_id', 'user_id');
    }
    public function physician()
    {
        return $this->hasMany(Physician::class, 'user_id', 'user_id');
    }
    public function attachment()
    {
        return $this->hasMany(Attachment::class, 'user_id', 'user_id');
    }
}
