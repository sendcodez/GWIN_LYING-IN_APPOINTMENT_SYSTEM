<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'patient_name',
        'date',
        'aog',
        'chief',
        'blood_pressure',
        'weight',
        'temperature',
        'cardiac',
        'respiratory',
        'fundic',
        'fht',
        'ie',
        'diagnosis',
        'follow_up',
        'plan',
       
    ];
    protected $casts = [
        'plan' => 'array',
    ];
}
