<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Physician extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'physician';
    protected $fillable = [
        'user_id',
        'bed',
        'date',
        'time',
        'physician',
        'order',
        'time_noted'

    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
