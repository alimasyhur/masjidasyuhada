<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRelawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'date_attendance',
    ];
}
