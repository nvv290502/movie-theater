<?php

namespace App\Repositories\RoomSeat;

interface RoomSeatRepositoryInterface{
    public function findByRoomIdAndSeatId($roomId, $seatId);
}