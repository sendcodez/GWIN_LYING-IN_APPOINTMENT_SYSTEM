<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{

    use HasFactory,SoftDeletes;
    protected $table = 'delivery';
    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'birthtime',
        'sex',
        'weight',
        'hc',
        'cc',
        'ac',
        'bl',
        'birth_order',
        'aog',
        'hepa',
        'bcg',
        'nbs',
        'hearing',
        'handle',
        'assist',
        'referral',

    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
