<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $table = 'website';
    protected $fillable = [
        'logo',
        'business_name',
        'tagline',
        'tagline2',
        'about_us',
        'contact_no',
        'email',
        'address',
    ];
}
