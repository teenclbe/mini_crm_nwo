<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Room 1',
            'description' => 'Room for 20 people',
            'price_per_hour' => 50.00,
            'capacity' => 20
        ]);
        Room::create([
            'name' => 'Room 2',
            'description' => 'Room for 10 people',
            'price_per_hour' => 30.00,
            'capacity' => 10
        ]);
        Room::create([
            'name' => 'Room 3',
            'description' => 'Room for 50 people',
            'price_per_hour' => 100.00,
            'capacity' => 50
        ]);
    }
}
