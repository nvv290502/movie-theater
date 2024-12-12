<?php

namespace App\Repositories\Showtime;

use Illuminate\Http\Request;

interface ShowtimeRepositoryInterface
{
    public function getShowtimeByMovie($movieId);
    public function getShowtimeByRoomAndSchedule($roomId, $scheduleId);
    public function saveShowtime(Request $request);
    public function updatePriceTicket($showtimeId, $price);
    public function getPriceTicket($scheduleId, $roomId);
}