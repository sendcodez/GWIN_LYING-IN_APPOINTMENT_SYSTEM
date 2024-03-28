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
}
