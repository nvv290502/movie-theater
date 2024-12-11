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
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
