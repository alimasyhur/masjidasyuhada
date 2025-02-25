<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity',
        'email',
        'fullname',
        'wa_number',
        'address',
        'frequency',
        'is_checked',
        'date_checked',
    ];
}
