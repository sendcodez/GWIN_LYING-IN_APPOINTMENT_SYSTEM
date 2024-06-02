<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newborn extends Model
{
    
    use HasFactory,SoftDeletes;
    protected $table = 'newborn';

    protected $fillable = [
        'user_id',
        'card',
        'baby_lastname',
        'mother_lastname',
        'mother_firstname',
        'birthday',
        'birthtime',
        'date_collection',
        'time_collection',
        'weight',
        'sex',
        'aog',
        'feeding',
        'status',
        'birthplace',
        'address',
        'contact',
        'blood_collector',
        'staff',
        'result_received',
        'result',
        'date_claimed',
        'claimed_by',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
