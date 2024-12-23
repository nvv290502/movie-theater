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
        return $this->belongsToMany(Room::class, 'room_seat')->withPivot('type_seat');
    }

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class, 'seat_id', 'seat_id');
    }
}
