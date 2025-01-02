<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;
    protected $primaryKey = 'cinema_id';
    protected $fillable = ['cinema_name', 'cinema_image_url', 'address', 'hotline', 'description', 'is_enabled'];

    public function rooms()
    {
        return $this->hasMany(Room::class,'cinema_id');
    }
}
