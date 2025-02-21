<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity',
        'email',
        'fullname',
        'wa_number',
        'address',
        'point_total',
        'is_checked',
        'date_checked',
    ];
}
