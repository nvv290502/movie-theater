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
        return $this->belongsTo(Movie::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
