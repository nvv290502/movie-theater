<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;
    protected $primaryKey = 'cinema_id';

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
