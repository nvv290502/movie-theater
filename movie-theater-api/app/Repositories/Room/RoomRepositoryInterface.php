<?php

namespace App\Repositories\Room;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

interface RoomRepositoryInterface
{
    public function getAll($size);
    public function getAllIsEnabled($size, $isEnabled);
    public function getById($id);
    public function createOrUpdate(RoomRequest $request, $id);
    public function isEnabled(Room $room);
    public function existsRoom($roomName);
}