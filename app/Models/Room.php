<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnArgument;

class Room extends Model
{
    protected $fillable = ['name', 'description', 'price_per_hour', 'capacity'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
