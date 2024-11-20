<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
