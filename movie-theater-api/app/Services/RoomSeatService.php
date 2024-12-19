<?php

namespace App\Services;

use App\Exceptions\ObjectEmptyException;
use App\Models\Room;
use App\Models\RoomSeat;
use App\Repositories\Seat\SeatRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomSeatService
{

    protected $seatRepositoryInterface;

    public function __construct(SeatRepositoryInterface $seatRepositoryInterface)
    {
        $this->seatRepositoryInterface = $seatRepositoryInterface;
    }
    public function saveLayout($roomId, Request $request)
    {
        $roomSeats = [];
        foreach ($request->all() as $value) {
            $seat = $this->seatRepositoryInterface->getSeatByRowAndColumn($value['row_name'], $value['column_name']);
            if (!$seat) {
                return response()->json(['message' => 'Ghế không tồn tại: ' . $value['row_name'] . $value['column_name']], 404);
            }

            $roomSeat = [
                'seat_id' => $seat->seat_id,
                'room_id' => $roomId,
                'type_seat' => $value['type_seat'],
                'created_at' => date('y-m-d H:i:s'),
                'updated_at' => date('y-m-d H:i:s')
            ];
            $roomSeats[] = $roomSeat;
        }

        return RoomSeat::insert($roomSeats);
    }

    public function updateInitialization($roomId, $rowNumber, $columnNumber)
    {
        $room = Room::find($roomId);

        if (empty($room)) {
            throw new ObjectEmptyException('Phong khong ton tai');
        }

        return Room::updateOrCreate(
            ['room_id' => $roomId],
            [
                'number_seat_column' => $columnNumber,
                'number_seat_row' => $rowNumber
            ]
        );
    }

    public function updateStatusSeat($roomId, Request $request)
    {
        foreach ($request->all() as $value) {

            $seat = $this->seatRepositoryInterface->findByRowNameAndColumnName($value['row_name'], $value['column_name']);

            DB::table('room_seat as rs')
            ->where('rs.room_id', $roomId)
            ->where('rs.seat_id', $seat->seat_id)
            ->update([
                'type_seat' => $value['type_seat'],
            ]);
        }
    }
}
