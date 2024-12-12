<?php

namespace App\Repositories\Room;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomRepository implements RoomRepositoryInterface
{
    public function getAll($size)
    {
        return Room::query()->paginate($size);
    }

    public function getAllIsEnabled($size, $isEnabled)
    {
        return Room::where('is_enabled', $isEnabled)->paginate($size);
    }

    public function getById($id)
    {
        return Room::find($id);
    }

    public function createOrUpdate(RoomRequest $request, $id)
    {
        return Room::updateOrCreate(
            ['room_id' => $id],
            [
                'room_name' => $request['name'],
                'location' => $request['location'],
                'room_type' => $request['type'],
                'cinema_id' => $request['cinema_id']
            ]
        );
    }

    public function isEnabled(Room $room)
    {
        return $room->update(['is_enabled' => !$room->is_enabled]);
    }

    public function existsRoom($roomName)
    {
        return Room::where('room_name', $roomName)->exists();
    }

    public function getRoomByCinema($cinemaId, $size)
    {
        return Room::where('cinema_id', $cinemaId)->paginate($size);
    }

    public function getRoomIsEnabledByCinema($cinemaId, $size)
    {
        return Room::where('cinema_id', $cinemaId)->where('is_enabled',1)->paginate($size);
    }

    public function getRoomByShowtime($movieId, $showTime, $showDate, $cinemaId)
    {
        // $query =  Room::whereHas('scheduleRoom.schedules.movies', function($query) use ($movieId){
        //     $query->where('movie_id', $movieId);
        // })
        // ->when($showTime, function($query) use ($showTime){
        //     $query->whereHas('scheduleRoom.schedules', function($subquery) use($showTime){
        //         $subquery->where('schedule_time', $showTime);
        //     });
        // })
        // ->when($showDate, function($query) use ($showDate){
        //     $query->whereHas('scheduleRoom.schedules', function($subquery) use($showDate){
        //         $subquery->where('schedule_date', $showDate);
        //     });
        // })
        // ->when($cinemaId, function($query) use ($cinemaId){
        //     $query->whereHas('cinemas', function($subquery) use ($cinemaId){
        //         $subquery->where('cinema_id', $cinemaId);
        //     });
        // });

        // $sql = $query->toSql();
        // dd($sql);

        return DB::table('rooms as r')
        ->join('cinemas as c','c.cinema_id','r.cinema_id')
        ->join('schedule_room as sr', 'sr.room_id', 'r.room_id')
        ->join('schedules as sch','sch.schedule_id', 'sr.schedule_id')
        ->join('movies as m','m.movie_id','sch.movie_id')
        ->where('m.movie_id', $movieId)
        ->when($showTime, function($query) use ($showTime){
            $query->where('sch.schedule_time', $showTime);
        })
        ->when($showDate, function($query) use ($showDate){
            $query->where('sch.schedule_date', $showDate);
        })
        ->when($cinemaId, function($query) use ($cinemaId){
            $query->where('c.cinema_id', $cinemaId);
        })
        ->select('r.*')
        ->distinct()
        ->get();
    }
}