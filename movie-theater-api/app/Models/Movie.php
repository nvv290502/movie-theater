<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['movie_name', 'duration', 'is_enabled', 'release_date', 'author', 'actor', 'language', 'trailer', 'summary', 'poster_url', 'banner_url'];
    protected $primaryKey = 'movie_id';

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category', 'movie_id','category_id')->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
