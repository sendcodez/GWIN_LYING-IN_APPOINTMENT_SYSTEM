<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'medical_histories'; // Specify custom table name

    protected $fillable = [
        'patient_id',
        'hypertension',
        'heartdisease',
        'asthma',
        'tuberculosis',
        'diabetes',
        'goiter',
        'epilepsy',
        'allergy',
        'hepatitis',
        'vdrl',
        'bleeding',
        'operation',
        'others',
        'tt1',
        'tt2',
        'tt3',
        'tt4',
        'tt5',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
