<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSeat extends Model
{
    use HasFactory;

    protected $primaryKey = ['seat_id', 'room_id'];
    protected $table = 'room_seat';
    protected $fillable = ['seat_id', 'room_id','type_seat'];
    
}
