<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ultrasound extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'patient_id',
        'patient_name',
        'date',
        'result',
        'attachment',
    ];
}
