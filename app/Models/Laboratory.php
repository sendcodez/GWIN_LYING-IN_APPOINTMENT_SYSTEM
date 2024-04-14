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
        'patient_id',
        'patient_name',
        'date',
        'urinalysis',
        'cbc',
        'blood_type',
        'hbsag',
        'vdrl',
        'fbs',

    ];
}
