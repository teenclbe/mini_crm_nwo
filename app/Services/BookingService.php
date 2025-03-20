<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;

class BookingService
{
    public function create(array $data): array
    {
        $roomIds = $data['room_ids'];
        $rooms = Room::findOrFail($roomIds);
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];

        foreach ($rooms as $room) {
            $availabilityCheck = $this->checkAvailability($room, $startTime, $endTime);
            if (!$availabilityCheck['success']) {
                return [
                    'success' => false,
                    'message' => $availabilityCheck['message'],
                ];
            }
        }

        $totalPrice = $this->calculateTotalPrice($rooms, $startTime, $endTime);

        $data['total_price'] = $totalPrice;
        $data['status'] = 'pending';
        unset($data['room_ids']);
        $booking = Booking::create($data);

        $booking->rooms()->attach($roomIds);

        return [
            'success' => true,
            'booking' => $booking,
        ];
    }

    public function update(Booking $booking, array $data): array
    {
        $roomIds = $data['room_ids'];
        $rooms = Room::findOrFail($roomIds);
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];

        foreach ($rooms as $room) {
            $availabilityCheck = $this->checkAvailability($room, $startTime, $endTime, $booking);
            if (!$availabilityCheck['success']) {
                return [
                    'success' => false,
                    'message' => $availabilityCheck['message'],
                ];
            }
        }

        $totalPrice = $this->calculateTotalPrice($rooms, $startTime, $endTime);

        $data['total_price'] = $totalPrice;
        unset($data['room_ids']);
        $booking->update($data);

        $booking->rooms()->sync($roomIds);

        return [
            'success' => true,
            'booking' => $booking,
        ];
    }

    private function checkAvailability(Room $room, string $startTime, string $endTime, ?Booking $ignoreBooking = null): array
    {
        $conflictingBookings = Booking::whereHas('rooms', function ($query) use ($room) {
            $query->where('room_id', $room->id);
        })
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->when($ignoreBooking, function ($query) use ($ignoreBooking) {
                $query->where('id', '!=', $ignoreBooking->id);
            })
            ->exists();

        if ($conflictingBookings) {
            return [
                'success' => false,
                'message' => "Room {$room->name} is already booked at this time. Choose another time or room.",
            ];
        }

        return ['success' => true];
    }

    private function calculateTotalPrice($rooms, string $startTime, string $endTime): float
    {
        $start = new \DateTime($startTime);
        $end = new \DateTime($endTime);
        $hours = $start->diff($end)->h + ($start->diff($end)->days * 24);

        $totalPrice = 0;
        $roomCount = count($rooms);

        foreach ($rooms as $index => $room) {
            $roomPrice = $room->price_per_hour * $hours;

            if ($roomCount >= 2 && $index == 1) {
                $roomPrice *= 0.9;
            } elseif ($roomCount >= 3 && $index >= 2) {
                $roomPrice *= 0.8;
            }

            $totalPrice += $roomPrice;
        }

        return $totalPrice;
    }
}