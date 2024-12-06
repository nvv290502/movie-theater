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
        return $this->belongsToMany(BillDetail::class);
    }
}
