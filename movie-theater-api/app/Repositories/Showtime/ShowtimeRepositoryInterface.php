<?php

namespace App\Repositories\Showtime;

interface ShowtimeRepositoryInterface
{
    public function getShowtimeByMovie($movieId);
    public function getShowtimeByRoomAndSchedule($roomId, $scheduleId);
}