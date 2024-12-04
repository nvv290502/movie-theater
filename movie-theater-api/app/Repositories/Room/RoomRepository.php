<?php

namespace App\Repositories\Room;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

class RoomRepository implements RoomRepositoryInterface
{
    public function getAll($size)
    {
        return Room::query()->paginate($size);
    }

    public function getAllIsEnabled($size, $isEnabled)
    {
        return Room::where('is_enabled', $isEnabled)->paginate($size);
    }

    public function getById($id)
    {
        return Room::find($id);
    }

    public function createOrUpdate(RoomRequest $request, $id)
    {
        return Room::updateOrCreate(
            ['room_id' => $id],
            [
                'room_name' => $request['name'],
                'location' => $request['location'],
                'room_type' => $request['type'],
                'cinema_id' => $request['cinema_id']
            ]
        );
    }

    public function isEnabled(Room $room)
    {
        return $room->update(['is_enabled' => !$room->is_enabled]);
    }

    public function existsRoom($roomName)
    {
        return Room::where('room_name', $roomName)->exists();
    }

    public function getRoomByCinema($cinemaId, $size)
    {
        return Room::where('cinema_id', $cinemaId)->paginate($size);
    }

    public function getRoomIsEnabledByCinema($cinemaId, $size)
    {
        return Room::where('cinema_id', $cinemaId)->where('is_enabled',1)->paginate($size);
    }
}