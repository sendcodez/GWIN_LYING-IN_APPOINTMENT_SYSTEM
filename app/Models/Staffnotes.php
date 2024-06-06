<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staffnotes extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'staffnotes';
    protected $fillable = [
        'user_id',
        'bed',
        'date',
        'time',
        'remarks',

    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
