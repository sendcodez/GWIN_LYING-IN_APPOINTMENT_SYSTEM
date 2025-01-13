<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyHistory extends Model
{
    protected $table = 'pregnancy_histories'; // Specify custom table name

    use HasFactory;

    protected $fillable = [
        'user_id',
        'pregnancy',
        'pregnancy_date',
        'aog',
        'manner',
        'bw',
        'sex',
        'present_status',
        'complications',
    ];

}
