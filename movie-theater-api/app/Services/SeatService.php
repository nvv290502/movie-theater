<?php

namespace App\Services;

use App\Exceptions\ObjectEmptyException;
use App\Models\Room;
use App\Repositories\Seat\SeatRepositoryInterface;

class SeatService{
    protected $seatRepositoryInterface;

    public function __construct(SeatRepositoryInterface $seatRepositoryInterface){
        $this->seatRepositoryInterface = $seatRepositoryInterface;
    }

    public function getSeatByRoom($roomId){
        $room = Room::find($roomId);
        if(empty($room)){
            throw new ObjectEmptyException('Phong khong ton tai');
        }

        return $this->seatRepositoryInterface->getSeatByRoom($roomId);
    }

    public function getSeatByBillDetail($movieId, $roomId, $showDate, $showTime, $userId)
    {
        return $this->seatRepositoryInterface->getSeatByBillDetail($movieId, $roomId, $showDate, $showTime, $userId);
    }
}