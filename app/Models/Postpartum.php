<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postpartum extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'postpartum';
    protected $fillable = [
        'user_id',
        'date',
        'time',
        'temperature',
        'pr',
        'rr',
        'bp',
        'u',
        's',

    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
