<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_id';
    protected $fillable = ['room_name','location','room_type','number_seat_column','number_seat_row','is_enabled','cinema_id','room_id'];

    public function cinemas()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_room', 'room_id', 'schedule_id')->using(ScheduleRoom::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seat::class)->using(RoomSeat::class);
    }

    public function scheduleRoom(){
        return $this->hasMany(ScheduleRoom::class, 'room_id');
    }


}
