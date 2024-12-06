<?php

namespace App\Repositories\Showtime;

use App\Models\ScheduleRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShowtimeRepository implements ShowtimeRepositoryInterface
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

    public function saveShowtime(Request $request)
    {
        Log::info([
            'schedule_id' => $request->scheduleId,
            'room_id' => $request->roomId,
            'price' => 0.00,
        ]);
        
        return ScheduleRoom::create(
            [
                'schedule_id' => $request->scheduleId,
                'room_id' => $request->roomId,
                'price' => 0
            ]
        );

        // return DB::table('schedule_room')->insert([
        //     'schedule_id' => $request->scheduleId,
        //     'room_id' => $request->roomId,
        //     'price' => 0.00
        // ]);
    }

    public function updatePriceTicket($showtimeId, $price)
    {
        return ScheduleRoom::where('schedule_room_id', $showtimeId)->update(['price' => $price]);
    }
}
