<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
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
        <h1 class="text-2xl font-bold mb-5">Rooms List</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">{{ session('success') }}
            </div>
        @endif
        <div class="mb-5">
            <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add
                Room</a>
        </div>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Price/Hour</th>
                    <th class="py-2 px-4 border-b">Capacity</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $room->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $room->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $room->description }}</td>
                        <td class="py-2 px-4 border-b">{{ $room->price_per_hour }}</td>
                        <td class="py-2 px-4 border-b">{{ $room->capacity }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('rooms.edit', $room) }}"
                                class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline-block ml-2">
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
</body>

</html>