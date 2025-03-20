<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms Bookings CRM</title>
    <link href="{{ Vite::asset('resources/css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold">Rooms Bookings CRM</a>
            <div class="space-x-4">
                <a href="{{ route('rooms.index') }}" class="hover:underline">Rooms</a>
                <a href="{{ route('bookings.index') }}" class="hover:underline">Bookings</a>
                <a href="{{ route('bookings.calendar') }}" class="hover:underline">Calendar</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            <div class="bg-white p-4 rounded shadow flex items-center">
                <i class="fas fa-door-open text-blue-500 text-2xl mr-3"></i>
                <div>
                    <h3 class="text-lg font-semibold">Total Rooms</h3>
                    <p class="text-gray-700">{{ $totalRooms }}</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded shadow flex items-center">
                <i class="fas fa-calendar-check text-green-500 text-2xl mr-3"></i>
                <div>
                    <h3 class="text-lg font-semibold">Total Bookings</h3>
                    <p class="text-gray-700">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>

        <div class="flex space-x-4 mb-5">
            <a href="{{ route('rooms.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
                <i class="fas fa-plus mr-2"></i> Create a Room
            </a>
            <a href="{{ route('bookings.create') }}"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 flex items-center">
                <i class="fas fa-book mr-2"></i> Create a Booking
            </a>
            <a href="{{ route('bookings.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center">
                <i class="fas fa-list mr-2"></i> View All Bookings
            </a>
            <a href="{{ route('bookings.calendar') }}"
                class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i> View Calendar
            </a>
        </div>

        <div class="bg-white p-5 rounded shadow mb-5">
            <h2 class="text-xl font-semibold mb-3">Recent Bookings</h2>
            @if ($recentBookings->isEmpty())
                <p class="text-gray-700">No recent bookings yet.</p>
            @else
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="py-2 px-4 border-b">Customer</th>
                            <th class="py-2 px-4 border-b">Rooms</th>
                            <th class="py-2 px-4 border-b">Start Time</th>
                            <th class="py-2 px-4 border-b">End Time</th>
                            <th class="py-2 px-4 border-b">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBookings as $booking)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b">{{ $booking->customer_name }}</td>
                                <td class="py-2 px-4 border-b">
                                    @foreach ($booking->rooms as $room)
                                        {{ $room->name }}@if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="py-2 px-4 border-b">{{ $booking->start_time }}</td>
                                <td class="py-2 px-4 border-b">{{ $booking->end_time }}</td>
                                <td class="py-2 px-4 border-b">${{ $booking->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
</body>

</html>