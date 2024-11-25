<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_id';

    public function cinemas()
    {
        return $this->belongsTo(Cinema::class);
    }
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class)->using(ScheduleRoom::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class)->using(RoomSeat::class);
    }
}
