<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'broadcast_text',
        'image_first',
        'image_second',
        'point',
        'start_date',
        'end_date',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title);
        });
    }
}
