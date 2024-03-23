<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PregnancyHistory extends Model
{
    protected $table = 'pregnancy_histories'; // Specify custom table name

    protected $fillable = [
        'patient_id',
        'gravida',
        'para',
        't',
        'p',
        'a',
        'l',
        'pregnancy',
        'pregnancy_date',
        'aog',
        'manner',
        'bw',
        'sex',
        'present_status',
        'complications',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
