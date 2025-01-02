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
        // return Schedule::join('schedule_room as sr', 'sr.schedule_id', 'schedules.schedule_id')
        //     ->join('rooms as r', 'r.room_id', 'sr.room_id')
        //     ->join('cinemas as c', 'c.cinema_id', 'r.cinema_id')
        //     ->where('schedules.movie_id', $movieId)
        //     ->where('schedules.schedule_date', '>=', DB::raw('DATE(NOW())'))
        //     ->where('schedules.schedule_time', '>=', DB::raw('TIME(NOW())'))
        //     ->when($city, function ($query, $city) {
        //         $query->where('c.address', 'like', '%' . $city . '%');
        //     })
        //     ->when($showDate, function ($query, $showDate) {
        //         $query->where('schedules.schedule_date', $showDate);
        //     })
        //     ->when($cinemaId, function ($query, $cinemaId) {
        //         $query->where('c.cinema_id', $cinemaId);
        //     })
        //     ->orderBy('schedules.schedule_time', 'ASC')
        //     ->distinct()
        //     ->get();

        return Schedule::where('movie_id', $movieId)
            ->whereDate('schedule_date', '>=', now())
            ->whereTime('schedule_time', '>=', now())
            ->when($city, function ($query, $city) {
                $query->whereHas('scheduleRoom.rooms.cinemas', function ($q) use ($city) {
                    $q->where('address', 'like', '%' . $city . '%');
                });
            })
            ->when($showDate, function ($query, $showDate) {
                $query->where('schedule_date', $showDate);
            })
            ->when($cinemaId, function ($query, $cinemaId) {
                $query->whereHas('scheduleRoom.rooms.cinemas', function ($q) use ($cinemaId) {
                    $q->where('cinema_id', $cinemaId);
                });
            })
            ->orderBy('schedule_time')
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

        // return Schedule::with(['movies:movie_id,movie_name,poster_url,duration'])
        //     ->whereHas('scheduleRoom.rooms', function($q) use ($roomId){
        //         $q->where('room_id', $roomId);
        //     })
        //     ->get();
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
        // return DB::table('schedules as sch')
        //     ->join('movies as m', 'm.movie_id', 'sch.movie_id')
        //     ->join('schedule_room as sr', 'sr.schedule_id', 'sch.schedule_id')
        //     ->where('sr.room_id', $roomId)
        //     ->select('sch.schedule_id', 'm.movie_id', 'm.poster_url', 'sch.schedule_date', 'sch.schedule_time', 'm.duration', 'm.movie_name')
        //     ->get();

        $result =  Schedule::with(['movies:movie_id,movie_name,poster_url,duration'])
            ->whereHas('scheduleRoom', function ($q) use ($roomId) {
                $q->where('room_id', $roomId);
            })->get();

        return $result;
    }

    public function saveOrUpdate(Request $request)
    {
        return Schedule::updateOrCreate(
            [
                'schedule_id' => $request->scheduleId,
            ],
            [
                'movie_id' => $request->movieId,
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

    public function getListScheduleManager($size)
    {
        $result =  DB::table('schedules as sch')
            ->join('schedule_room as sr', 'sr.schedule_id', 'sch.schedule_id')
            ->join('rooms as r', 'r.room_id', 'sr.room_id')
            ->join('cinemas as c', 'c.cinema_id', 'r.cinema_id')
            ->join('movies as m', 'm.movie_id', 'sch.movie_id')
            ->select('m.movie_id', 'm.duration', 'r.room_id', 'c.cinema_id', 'sch.schedule_id', 'sch.schedule_date', 'sch.schedule_time', 'sr.price', 'm.movie_name', 'r.room_name', 'c.cinema_name', 'sr.schedule_room_id')
            ->orderBy('sch.schedule_date', 'desc')
            ->orderBy('sch.schedule_time', 'desc')
            ->paginate($size);

        return $result;

        // return Schedule::with([
        //     'movies:movie_id,duration,movie_name',
        //     // 'scheduleRoom:schedule_room_id,price',
        //     'scheduleRoom.rooms:room_id,room_name',
        //     'scheduleRoom.rooms.cinemas:cinema_id,cinema_name'
        // ])
        //     ->orderByDesc('schedule_date')
        //     ->orderByDesc('schedule_time')
        //     ->paginate($size);
    }

    public function getScheduleByMovieAndShowDateAndShowTime($movieId, $showDate, $showTime)
    {
        return Schedule::where('movie_id', $movieId)
            ->where('schedule_time', $showTime)
            ->where('schedule_date', $showDate)
            ->first();
    }
}
