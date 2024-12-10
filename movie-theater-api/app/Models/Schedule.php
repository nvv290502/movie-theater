<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['movie_id','schedule_date','schedule_time','schedule_id'];

    public function movies()
    {
        return $this->belongsTo(Movie::class, 'schedule_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'schedule_room','schedule_id','room_id')->using(ScheduleRoom::class);
    }

    public function scheduleRoom()
    {
        return $this->hasMany(ScheduleRoom::class, 'schedule_id');
    }
}
