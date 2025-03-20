<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'start_time',
        'end_time',
        'total_price',
        'status',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room');
    }
}