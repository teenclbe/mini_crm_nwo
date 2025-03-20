<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(): View
    {
        $bookings = Booking::with('rooms')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $rooms = Room::all();
        return view('bookings.create', compact('rooms'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $result = $this->bookingService->create($request->validated());

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message'])->withInput();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking): View
    {
        $rooms = Room::all();
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $result = $this->bookingService->update($booking, $request->validated());

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message'])->withInput();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }

    public function showCalendar(): View
    {
        return view('bookings.calendar');
    }

    public function calendar(): JsonResponse
    {
        $bookings = Booking::with('rooms')->get();

        $events = $bookings->map(function ($booking) {
            $color = match ($booking->status) {
                'pending' => '#6b7280', 
                'confirmed' => '#10b981', 
                'canceled' => '#ef4444', 
                default => '#6b7280',
            };

            return [
                'id' => $booking->id,
                'title' => $booking->customer_name,
                'start' => $booking->start_time, 
                'end' => $booking->end_time,     
                'extendedProps' => [
                    'rooms' => $booking->rooms->pluck('name')->implode(', '),
                    'status' => $booking->status,
                ],
                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        });

        return response()->json($events);
    }
    public function updateStatus(Booking $booking): JsonResponse
    {
        $status = request()->input('status');
        if (!in_array($status, ['pending', 'confirmed', 'canceled'])) {
            return response()->json(['success' => false, 'message' => 'Invalid status'], 400);
        }

        $booking->update(['status' => $status]);
        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}