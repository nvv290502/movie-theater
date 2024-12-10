<?php

namespace App\Repositories\BillDetail;

use App\Models\BillDetail;
use Illuminate\Support\Facades\DB;

class BillDetailRepository
{
    public function getBillDetail($billCode)
    {
        // return DB::table('bill_detail as bd')
        // ->join('schedule_room as sr','sr.schedule_id','bd.schedule_id')
        // ->join('rooms as r','r.room_id', 'bd.room_id')
        // ->join('cinemas as c','c.cinema_id','r.cinema_id')
        // ->join('seats as s','s.seat_id','bd.seat_id')
        // ->where('bd.bill_code', $billCode)
        // ->select('r.room_id','r.room_name','c.cinema_name','s.seat_id','s.column_name','s.row_name','bd.price')
        // ->distinct()
        // ->get();

        return BillDetail::with(['scheduleRoom.rooms', 'scheduleRoom.rooms.cinemas', 'seats'])
        ->whereHas('bills', function ($query) use ($billCode){
            $query->where('bill_code',$billCode);
        })
        ->get()
        ->map(function ($billDetail) {
            return [
                'billCode' => $billDetail->bills->bill_code,
                'roomId' => $billDetail->scheduleRoom->rooms->room_id,
                'roomName' => $billDetail->scheduleRoom->rooms->room_name,
                'cinemaName' => $billDetail->scheduleRoom->rooms->cinemas->cinema_name,
                'seatId' => $billDetail->seats->seat_id,
                'columnName' => $billDetail->seats->column_name,
                'rowName' => $billDetail->seats->row_name,
                'price' => $billDetail->price,
            ];
        });
    }

    // public function getBillByUser($userId, $date, $billCode, $size)
    // {
    //     return BillDetail::with(['scheduleRoom.rooms', 'scheduleRoom.schedules.movies'])
    //     ->whereHas('bills', function($query) use ($billCode){
    //         $query->where('bill_code', $billCode);
    //     })
    //     ->when()
    // }
}
