<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregnancy_term extends Model
{
    protected $table = 'pregnancy_terms'; // Specify custom table name

    protected $fillable = [
        'patient_id',
        'gravida',
        'para',
        't',
        'p',
        'a',
        'l',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}


