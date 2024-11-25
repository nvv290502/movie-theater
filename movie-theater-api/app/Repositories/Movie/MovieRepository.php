<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAll($size)
    {
        return Movie::query()->paginate($size);
    }

    public function getAllIsEnabled($size, $isEnabled)
    {
        return Movie::where('is_enabled', $isEnabled)->paginate($size);
    }

    public function getById($id)
    {
        return Movie::where('is_enabled', 1)->find($id);
    }

    public function create(array $request)
    {
        return Movie::create([
            'movie_name' => $request['name'],
            'duration' => $request['duration'],
            'releaseDate' => $request['releaseDate'],
            'author' => $request['author'],
            'actor' => $request['actor'],
            'trailer' => $request['trailer'],
            'summary' => $request['summary'],
            'language' => $request['language'],
            'poster_url' => $request['poster'],
            'banner_url' => $request['banner'],
        ]);
    }

    public function existsMovie($movieName)
    {
        return Movie::where('movie_name', $movieName)->exists();
    }

    public function update(array $request, $id)
    {
        return Movie::updateOrCreate(
            ['movie_id' => $id],
            [
                'movie_name' => $request['name'],
                'duration' => $request['duration'],
                'releaseDate' => $request['releaseDate'],
                'author' => $request['author'],
                'actor' => $request['actor'],
                'trailer' => $request['trailer'],
                'summary' => $request['summary'],
                'language' => $request['language'],
                'poster_url' => $request['poster'],
                'banner_url' => $request['banner'],
            ]
        );
    }

    public function isEnabled(Movie $movie)
    {
        return $movie->update([
            'is_enabled' => !$movie->is_enabled,
        ]);
    }

    public function getUpcomingMovie()
    {
        return Movie::where('release_date', '>', now())
            ->where('release_date', '<', now()->addDays(7))
            ->get();
    }
}
