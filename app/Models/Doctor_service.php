<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_service extends Model
{
    use HasFactory;
    protected $table = 'doctor_services';
    protected $fillable = [
        'doctor_id',
        'service_id',
    ];

    
}
