<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule;
use App\Models\ScheduleRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function getScheduleByCinema($movieId, $city = null, $showDate = null, $cinemaId = null)
    {
        return DB::table('schedules as sch')
            ->join('schedule_room as sr', 'sr.schedule_id', 'sch.schedule_id')
            ->join('rooms as r', 'r.room_id', 'sr.room_id')
            ->join('cinemas as c', 'c.cinema_id', 'r.cinema_id')
            ->where('sch.movie_id', $movieId)
            ->where('sch.schedule_date', '>=', DB::raw('DATE(NOW())'))
            ->where('sch.schedule_time', '>=', DB::raw('TIME(NOW())'))
            ->when($city, function ($query, $city) {
                $query->where('c.address', 'like', '%' . $city . '%');
            })
            ->when($showDate, function ($query, $showDate) {
                $query->where('sch.schedule_date', $showDate);
            })
            ->when($cinemaId, function ($query, $cinemaId) {
                $query->where('c.cinema_id', $cinemaId);
            })
            ->select('sch.*')
            ->orderBy('sch.schedule_time', 'ASC')
            ->distinct()
            ->get();
    }

    public function getScheduleByMoviAndShowdateAndShowtime($movieId, $showDate, $showTime)
    {
        return ScheduleRoom::where('movie_id', $movieId)
            ->where('schedule_date', $showDate)
            ->where('schedule_time', $showTime)
            ->first();
    }

    public function findByRoomId($roomId)
    {
        return DB::table('schedules as sch')
            ->join('schedule_room as sr', 'sr.schedule_id', 'sch.schedule_id')
            ->join('movies as m', 'm.movie_id', 'sch.movie_id')
            ->where('sr.room_id', $roomId)
            ->select('sch.schedule_id', 'm.movie_id', 'm.movie_name', 'm.poster_url', 'sch.schedule_date', 'sch.schedule_time', 'm.duration')
            ->get();
    }

    public function countTicketBySchedule($scheduleId)
    {
        return DB::table('schedules as sch')
            ->join('bill_detail as bd', 'bd.schedule_id', 'sch.schedule_id')
            ->where('sch.schedule_id', $scheduleId)
            ->get();
    }

    public function getScheduleByRoom($roomId)
    {
        return DB::table('schedules as sch')
            ->join('movies as m', 'm.movie_id', 'sch.movie_id')
            ->join('schedule_room as sr', 'sr.schedule_id', 'sch.schedule_id')
            ->where('sr.room_id', $roomId)
            ->select('sch.schedule_id', 'm.movie_id', 'm.poster_url', 'sch.schedule_date', 'sch.schedule_time', 'm.duration', 'm.movie_name')
            ->get();
    }

    public function saveOrUpdate(Request $request)
    {
        return Schedule::updateOrCreate(
            [
                'movie_id' => $request->movieId,
                'schedule_date' => $request->date,
                'schedule_time' => $request->time,
            ],
            [
                'schedule_date' => $request->date,
                'schedule_time' => $request->time,
                'time_end' => $request->end,
            ]
        );
    }

    public function checkExistsSchedule(Request $request)
    {
        return Schedule::where('movie_id', $request->movieId)
            ->where('schedule_date', $request->date)
            ->where('schedule_time', $request->time)
            ->exists();
    }

    public function getExistsSchedule(Request $request)
    {
        return Schedule::where('movie_id', $request->movieId)
            ->where('schedule_date', $request->date)
            ->where('schedule_time', $request->time)
            ->first();
    }
}
