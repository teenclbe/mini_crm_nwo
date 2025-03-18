<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['customer_name', 'customer_phone', 'customer_email', 'room_id', 'start_time', 'end_time', 'status', 'total_price'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
