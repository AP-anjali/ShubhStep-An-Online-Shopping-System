<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'description',
        'date_time',
        'is_active',
    ];

    public function subEvents()
    {
        return $this->hasMany(SubEvent::class);
    }
}
