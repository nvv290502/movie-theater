<?php

namespace App\Repositories\Review;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;

class ReviewRepository
{
    public function getReviewByMovie($movieId)
    {
        return Review::whereHas('movies', function ($query) use ($movieId) {
            $query->where('movie_id', $movieId);
        })->get();
    }

    public function existsByReview($movieId, $userId)
    {
        return Review::where('movie_id', $movieId)->where('user_id',$userId)->exists();
    }

    public function saveReview(ReviewRequest $request)
    {
        $review = new Review();
        $review->movie_id = $request['movieId'];
        $review->user_id = $request['userId'];
        $review->number_star = $request['numberStar'];
        $review->comment = $request['comment'];
        $review->save();
        return $review;
    }

    public function getReviewByMovieOrByUser($movieId, $userId, $size)
    {
        return Review::with('users')
        ->when($movieId, function($query) use ($movieId){
            $query->where('movie_id', $movieId);
        })
        ->when($userId, function($query) use ($userId){
            $query->where('user_id', $userId);
        })
        ->paginate($size);
    }
}
