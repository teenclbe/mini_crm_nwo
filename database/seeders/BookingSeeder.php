<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $room_1 = Room::first();
        Booking::create([
            'customer_name' => 'Maxim Polishchuk',
            'customer_phone' => '+380681212312',
            'customer_email' => 'maxim@gmail.com',
            'room_id' => $room_1->id,
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHours(2),
            'status' => 'confirmed',
            'total_price' => $room_1->price_per_hour * 2
        ]);
        $room_2 = Room::skip(1)->first();
        Booking::create([
            'customer_name' => 'Nemaxim Nepolishchuk',
            'customer_phone' => '+380681311310',
            'customer_email' => 'nemaxim@gmail.com',
            'room_id' => $room_2->id,
            'start_time' => now()->addDays(2),
            'end_time' => now()->addDay()->addHours(3),
            'status' => 'pending',
            'total_price' => $room_2->price_per_hour * 3
        ]);
    }
}
