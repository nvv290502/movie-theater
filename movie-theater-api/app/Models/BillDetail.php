<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    // protected $primaryKey = ['schedule_id', 'room_id', 'seat_id', 'bill_id'];
    protected $primaryKey = ['bill_detail_id'];

    public function scheduleRoom()
    {
        return $this->hasMany(ScheduleRoom::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
