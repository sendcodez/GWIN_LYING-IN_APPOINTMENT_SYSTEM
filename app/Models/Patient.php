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


    public function pregnancyHistories()
    {
        return $this->hasMany(PregnancyHistory::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }
}
