<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labor extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'labor';
    protected $fillable = [
        'user_id',
        'date',
        'time',
        'temperature',
        'pr',
        'rr',
        'bp',
        'fmt',
        'interval',
        'intensity',
        'frequency',

    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
