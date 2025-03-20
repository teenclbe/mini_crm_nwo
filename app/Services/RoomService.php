<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data)
    {
        $room->update($data);
    }

    public function delete(Room $room)
    {
        $room->delete();
    }
}