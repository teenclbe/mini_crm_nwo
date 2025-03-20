<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
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
        <h1 class="text-2xl font-bold mb-5">Edit Room</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('rooms.update', $room) }}" method="POST" class="max-w-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $room->name) }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea type="text" name="description" value="{{ old('description', $room->description) }}"
                    class="mt-1 p-2 w-full border rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="price_per_hour" class="block text-sm font-medium text-gray-700">Price per Hour</label>
                <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $room->price_per_hour) }}"
                    step="0.01" class="mt-1 p-2 w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}"
                    class="mt-1 p-2 w-full border rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            <a href="{{ route('rooms.index') }}"
                class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </form>
    </div>
</body>

</html>