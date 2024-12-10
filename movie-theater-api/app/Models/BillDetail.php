<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    // protected $primaryKey = ['schedule_id', 'room_id', 'seat_id', 'bill_id'];
    protected $primaryKey = 'bill_detail_id';
    protected $table = 'bill_detail';
    protected $fillable = ['bill_code','price','schedule_id','room_id','bill_id','seat_id','bill_detail_id'];

    public function scheduleRoom()
    {
        return $this->belongsTo(ScheduleRoom::class, 'schedule_room_id', 'schedule_room_id');
    }

    public function seats()
    {
        return $this->belongsTo(Seat::class,'seat_id','seat_id');
    }

    public function bills()
    {
        return $this->belongsTo(Bill::class,'bill_id');
    }
}
