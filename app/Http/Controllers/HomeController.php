<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $recentBookings = Booking::with('rooms')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('totalRooms', 'totalBookings', 'recentBookings'));
    }
}