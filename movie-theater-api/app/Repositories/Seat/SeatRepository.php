<?php

namespace App\Repositories\Seat;

use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class SeatRepository implements SeatRepositoryInterface
{
    public function findByRowNameAndColumnName($rowName, $columnName)
    {
        return Seat::where('row_name', $rowName)
        ->where('column_name', $columnName)
        ->first();
    }

    public function getSeatByRoom($roomId)
    {
        return DB::table('seats as s')
        ->join('room_seat as rs','rs.seat_id','s.seat_id')
        ->where('rs.room_id', $roomId)
        ->get();
    }
}