<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'contact_no',
        'address',
        'expertise',
        'day_availability',
        'time_availability',
        'email',
        'password',
        'usertype',
        'status',
    ];
}
