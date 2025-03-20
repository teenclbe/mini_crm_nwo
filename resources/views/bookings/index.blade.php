<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookings</title>
    <link href="{{ Vite::asset('resources/css/app.css') }}" rel="stylesheet">
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
        <h1 class="text-2xl font-bold mb-5">Bookings List</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">{{ session('success') }}
            </div>
        @endif
        <a href="{{ route('bookings.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-5 hover:bg-blue-600">Add Booking</a>
        <a href="{{ route('bookings.calendar') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-5 hover:bg-blue-600 ml-2">View Calendar</a>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Customer</th>
                    <th class="py-2 px-4 border-b">Rooms</th>
                    <th class="py-2 px-4 border-b">Start Time</th>
                    <th class="py-2 px-4 border-b">End Time</th>
                    <th class="py-2 px-4 border-b">Total Price</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $booking->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $booking->customer_name }}</td>
                        <td class="py-2 px-4 border-b">
                            @foreach ($booking->rooms as $room)
                                {{ $room->name }}@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="py-2 px-4 border-b">{{ $booking->start_time }}</td>
                        <td class="py-2 px-4 border-b">{{ $booking->end_time }}</td>
                        <td class="py-2 px-4 border-b">{{ $booking->total_price }}</td>
                        <td class="py-2 px-4 border-b">
                            <select class="status-select border rounded p-1" data-booking-id="{{ $booking->id }}">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
                            </select>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('bookings.edit', $booking) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline-block ml-2"
                                onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
</body>

</html>