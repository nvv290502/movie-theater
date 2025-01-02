<?php

namespace App\Repositories\Seat;

use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class SeatRepository implements SeatRepositoryInterface
{
    public function findByRowNameAndColumnName($rowName, $columnName)
    {
        return Seat::join('room_seat', 'room_seat.seat_id', '=', 'seats.seat_id')
            ->where('row_name', $rowName)
            ->where('column_name', $columnName)
            ->select('seats.*', 'room_seat.type_seat')
            ->first();
    }

    public function getSeatByRowAndColumn($rowName, $columnName)
    {
        return Seat::where('row_name', $rowName)
            ->where('column_name', $columnName)
            ->first();
    }


    public function getSeatByRoom($roomId)
    {
        return Seat::join('room_seat', 'room_seat.seat_id', '=', 'seats.seat_id')
            ->where('room_seat.room_id', $roomId)
            ->get();
    }

    public function getSeatByBillDetail($movieId, $roomId, $showDate, $showTime, $userId)
    {
        return DB::table('bill_detail as bd')
            ->join('schedule_room as sr', 'sr.schedule_room_id', 'bd.schedule_room_id')
            ->join('schedules as sch', 'sch.schedule_id', 'sr.schedule_id')
            ->join('movies as m', 'm.movie_id', 'sch.movie_id')
            ->join('rooms as r', 'r.room_id', 'sr.room_id')
            ->join('bills as b', 'b.bill_id', 'bd.bill_id')
            ->where('m.movie_id', $movieId)
            ->where('sch.schedule_time', $showTime)
            ->where('sch.schedule_date', $showDate)
            ->where('r.room_id', $roomId)
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->distinct()
            ->select('bd.seat_id')
            ->get();
    }
}
