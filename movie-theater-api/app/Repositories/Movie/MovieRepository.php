<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAll($size)
    {
        return Movie::with('categories')->paginate($size);
    }

    public function getAllIsEnabled($size, $isEnabled)
    {
        return Movie::with('categories:category_id')->where('is_enabled', $isEnabled)->paginate($size);
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
            'release_date' => $request['releaseDate'],
            'author' => $request['author'],
            'actor' => $request['actor'],
            'trailer' => $request['trailer'],
            'summary' => $request['summary'],
            'language' => $request['language'],
            'poster_url' => $request['poster'],
            'banner_url' => $request['banner'],
        ]);
    }

    public function existsMovie($movieName, $id)
    {
        return Movie::where('movie_name', $movieName)
            ->when($id, function ($query, $id) {
                $query->where('movie_id', '!=', $id);
            })
            ->exists();
    }

    public function update(array $request, $id)
    {
        $data = [
            'movie_name' => $request['name'],
            'duration' => $request['duration'],
            'release_date' => $request['releaseDate'],
            'author' => $request['author'],
            'actor' => $request['actor'],
            'trailer' => $request['trailer'],
            'summary' => $request['summary'],
            'language' => $request['language']
        ];

        if (!empty($request['poster'])) {
            $data['poster_url'] = $request['poster'];
        }

        if (!empty($request['banner'])) {
            $data['banner_url'] = $request['banner'];
        }

        return Movie::updated(
            ['movie_id' => $id],
            $data
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
            ->where('release_date', '<=', now()->addDays(7))
            ->get();
    }

    public function movieShowByDate($date)
    {
        return DB::table('schedules as sch')
            ->join('movies as m', 'sch.movie_id', '=', 'm.movie_id')
            ->join('schedule_room as s', 'sch.schedule_id', '=', 's.schedule_id')
            ->where('sch.schedule_date', $date)
            ->where('m.is_enabled', true)
            ->select('m.*',)
            ->distinct()
            ->get();
    }

    public function getMovieListCategoryIds(array $categoryIds)
    {
        return Movie::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.category_id', $categoryIds);
        })->get();
    }

    public function getMovieByShowTime($showTime, $showDate, $cinemaId)
    {
        return Movie::whereHas('schedules', function ($query) use ($showTime, $showDate, $cinemaId) {
            $query->where('schedule_time', $showTime)
                ->where('schedule_date', $showDate)
                ->whereHas('rooms', function ($query_r) use ($cinemaId) {
                    $query_r->where('rooms.cinema_id', $cinemaId);
                });
        })->get();
    }

    public function getListName()
    {
        return DB::table('movies as m')
            ->pluck('m.movie_name');
    }

    public function getByName($movieName)
    {
        return Movie::where('movie_name', $movieName)
            ->first();
    }

    public function getMovieIsShowing()
    {
        return Movie::where('is_enabled', 1)->where('release_date', '<=', now())->orderBy('release_date', 'desc')->get();
    }

    public function movieRevenue($startDate, $endDate)
    {
        $query =  Movie::selectRaw('movies.movie_id as movieId, movies.movie_name as movieName, SUM(bill_detail.price) as amountMoney, COUNT(bill_detail.bill_id) as numberTicket')
            ->leftJoin('schedules', 'movies.movie_id', '=', 'schedules.movie_id')
            ->leftJoin('schedule_room', 'schedule_room.schedule_id', '=', 'schedules.schedule_id')
            ->leftJoin('bill_detail', 'bill_detail.schedule_room_id', '=', 'schedule_room.schedule_room_id')
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate){
                $query->whereBetWeen('bill_detail.created_at', [$startDate, $endDate]);
            })
            ->groupBy('movies.movie_id', 'movies.movie_name')
            ->orderByDesc('amountMoney')
            ->get();

        return $query;
    }

    public function getTop10movieByNumberTicket()
    {

        $result = Movie::selectRaw('movies.movie_id as movieId, COUNT(bill_detail.seat_id) as numberTicket')
                ->join('schedules','schedules.movie_id','=','movies.movie_id')
                ->join('schedule_room','schedule_room.schedule_id','=', 'schedules.schedule_id')
                ->leftJoin('bill_detail','bill_detail.schedule_room_id','=', 'schedule_room.schedule_room_id')
                ->groupBy('movieId')
                ->orderByDesc('numberTicket')
                ->get();
        return $result;
    }

    public function getTop10movieByRating()
    {
        $result = Movie::selectRaw('movies.movie_id as movieId, COALESCE(ROUND(AVG(CAST(reviews.number_star AS FLOAT)),2), 0.0) as rating')
                ->leftJoin('reviews','reviews.movie_id','=','movies.movie_id')
                ->groupBy('movies.movie_id')
                ->orderByDesc('rating')
                ->get();

        return $result;
    }
}
