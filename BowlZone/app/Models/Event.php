<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_name',
        'event_date',
        'venue',
        'price_per_pax',
        'phone',
        'participants',
        'total_paid',
    ];

    protected $casts = [
        'event_date' => 'date',
        'price_per_pax' => 'decimal:2',
        'total_paid' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
