<?php

namespace App\Repositories\Showtime;

use App\Models\Room;
use App\Models\ScheduleRoom;
use Illuminate\Support\Facades\DB;

class ShowtimeRepository
{
    public function getShowtimeByMovie($movieId)
    {
        return DB::table('schedule_room as sr')
            ->join('schedules as sch', 'sch.schedule_id', 'sr.schedule_id')
            ->join('rooms as r', 'r.room_id', 'sr.room_id')
            ->join('cinemas as c', 'c.cinema_id', 'r.cinema_id')
            ->where('sch.movie_id', $movieId)
            ->where('sch.schedule_date', '>=', DB::raw('DATE(NOW())'))
            ->select('c.cinema_id', 'r.room_id', 'sch.schedule_date', 'sch.schedule_time', 'r.room_name', 'c.cinema_name')
            ->get();
    }

    public function getShowtimeByRoomAndSchedule($roomId, $scheduleId)
    {
        return ScheduleRoom::where('schedule_id', $scheduleId)
            ->where('room_id', $roomId)
            ->first();
    }
}
