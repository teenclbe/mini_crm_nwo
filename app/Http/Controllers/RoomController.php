<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Services\RoomService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoomController extends Controller
{
    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(): View
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        return view('rooms.create');
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $this->roomService->create($request->validated());
        return redirect()->route('rooms.index')->with('success', 'Room created successfully!');
    }

    public function edit(Room $room): View
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $this->roomService->update($room, $request->validated());
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $this->roomService->delete($room);
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }

}