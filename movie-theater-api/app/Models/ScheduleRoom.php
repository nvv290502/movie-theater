<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRoom extends Model
{
    use HasFactory;
    // protected $primaryKey = ['schedule_id', 'room_id'];
    protected $primaryKey = 'schedule_room_id';
    protected $table = 'schedule_room';
    protected $fillable = ['room_id','schedule_id','price'];

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class, 'schedule_room_id','schedule_room_id');
    }

    public function rooms(){
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function schedules(){
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
