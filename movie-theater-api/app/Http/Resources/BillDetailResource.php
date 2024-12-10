<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'roomId' => $this->scheduleRoom->rooms->room_id,
            'roomName' => $this->scheduleRoom->rooms->room_name,
            'cinemaName' => $this->scheduleRoom->rooms->cinemas->cinema_name,
            'seatId' => $this->seats->seat_id,
            'columnName' => $this->seats->column_name,
            'rowName' => $this->seats->row_name,
            'priceTicket' => $this->price,
        ];
    }
}
