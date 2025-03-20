<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Booking</title>
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
        <h1 class="text-2xl font-bold mb-5">Add New Booking</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('bookings.store') }}" method="POST" class="max-w-lg">
            @csrf
            <div class="mb-4">
                <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rooms</label>
                <div class="mt-1">
                    @foreach ($rooms as $room)
                        <div class="flex items-center">
                            <input type="checkbox" name="room_ids[]" value="{{ $room->id }}" id="room_{{ $room->id }}"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded room-checkbox"
                                data-price="{{ $room->price_per_hour }}" {{ in_array($room->id, old('room_ids', [])) ? 'checked' : '' }}>
                            <label for="room_{{ $room->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $room->name }} ({{ $room->price_per_hour }}/h, {{ $room->capacity }} people)
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('room_ids')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div id="discount-message" class="mt-2 text-sm text-green-600 hidden"></div>
            </div>
            <div class="mb-4">
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" name="start_time" value="{{ old('start_time') }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            <a href="{{ route('bookings.index') }}"
                class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </form>
    </div>
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
</body>

</html>