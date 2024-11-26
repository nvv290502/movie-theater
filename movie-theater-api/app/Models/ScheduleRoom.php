<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRoom extends Model
{
    use HasFactory;
    protected $primaryKey = ['schedule_id', 'room_id'];
    protected $tabel = 'schedule_room';

    public function billDetail()
    {
        return $this->belongsToMany(BillDetail::class);
    }
}
