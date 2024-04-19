<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'laboratories';

    protected $fillable = [
        'user_id',
        'patient_name',
        'date',
        'urinalysis',
        'cbc',
        'blood_type',
        'hbsag',
        'vdrl',
        'fbs',

    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
