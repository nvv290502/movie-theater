<?php

namespace App\Services;

use App\Exceptions\InvalidInputException;
use App\Exceptions\ObjectEmptyException;
use App\Models\Room;
use App\Models\Schedule;
use App\Repositories\Showtime\ShowtimeRepositoryInterface;
use Illuminate\Http\Request;

class ShowtimeService
{
    protected $showtimeRepositoryInterface;

    public function __construct(ShowtimeRepositoryInterface $showtimeRepositoryInterface)
    {
        $this->showtimeRepositoryInterface = $showtimeRepositoryInterface;
    }
    public function getShowtimeByMovie($movieId)
    {
        if(empty($movieId)){
            throw new InvalidInputException('Ban chua nhap id');
        }
        return $this->showtimeRepositoryInterface->getShowtimeByMovie($movieId);
    }

    public function saveShowtime(Request $request)
    {
        $schedule = Schedule::find($request->scheduleId);
        $room = Room::find($request->roomId);

        if(empty($schedule)){
            throw new ObjectEmptyException('Schedule khong ton tai');
        }

        if(empty($room)){
            throw new ObjectEmptyException('Room khong ton tai');
        }

        return $this->showtimeRepositoryInterface->saveShowtime($request);
    }

    public function updatePriceTicket($showtimeId, $price)
    {
        return $this->showtimeRepositoryInterface->updatePriceTicket($showtimeId, $price);
    }
}