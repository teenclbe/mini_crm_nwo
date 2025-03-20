<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <link href="{{ Vite::asset('resources/css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
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
        <h1 class="text-2xl font-bold mb-5">Booking Calendar</h1>
        <div id="calendar"></div>
        <a href="{{ route('bookings.index') }}"
            class="mt-5 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to List</a>
    </div>
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
</body>

</html>