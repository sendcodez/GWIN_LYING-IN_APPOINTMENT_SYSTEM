<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [

        'user_id',
        'name',
        'date',
        'description',
        'attachment',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
