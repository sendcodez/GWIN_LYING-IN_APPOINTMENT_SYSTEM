<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'doctor_id',
        'rest_day',
        
    ];
    protected $casts = [
        'rest_day' => 'date', // Make sure 'rest_day' is cast to a date
    ];
    public function doctor()
{
    return $this->belongsTo(Doctor::class);
}

}
