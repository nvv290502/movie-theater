<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $primaryKey = 'seat_id';

    public function rooms()
    {
        return $this->belongsToMany(Room::class)->using(RoomSeat::class);
    }

    public function billDetail()
    {
        return $this->belongsToMany(BillDetail::class);
    }
}
